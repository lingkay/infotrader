<?php

// src/AppBundle/Controller/OrdersController.php

namespace Evangeliko\AccountBundle\Controller;


use Evangeliko\AccountBundle\Entity\Order;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/orders")
 */
class OrdersController extends Controller
{
	public function newAction($amount)
	{
	    $em = $this->getDoctrine()->getManager();

	    $order = new Order($amount);
	    $em->persist($order);
	    $em->flush();

	    return $this->redirect($this->generateUrl('evangeliko_show_order', [
	        'id' => $order->getId(),
	    ]));
	}

	public function showAction(Request $request, Order $order)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		$account = $this->getUser()->getAccount();

		$notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);

		$notif_list = [];

		foreach ($notifs as $notif) {
			$notif_list[] = $notif;
		}

		$config = [
		    'paypal_express_checkout' => [
		        'return_url' => $this->generateUrl('app_orders_paymentcreate', [
		            'id' => $order->getId(),
		        ], UrlGeneratorInterface::ABSOLUTE_URL),
		        'cancel_url' => "http://socialmedia2.purltech.com/credit",
		    ],
		];

		$form = $this->createForm('jms_choose_payment_method', null, [
		    'amount'   => $order->getAmount(),
		    'currency' => 'USD',
		    'predefined_data' => $config,
		]);

	    $form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid()) {
	        $ppc = $this->get('payment.plugin_controller');
	        $ppc->createPaymentInstruction($instruction = $form->getData());

	        $order->setPaymentInstruction($instruction);

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($order);
	        $em->flush($order);

	        return $this->redirect($this->generateUrl('app_orders_paymentcreate', [
	            'id' => $order->getId(),
	        ]));
	    }

	    return [
	    	'notifs' => $notif_list,
	    	'object' => $user->getAccount(),
	        'order' => $order,
	        'form'  => $form->createView(),
	        'account' => $account
	    ];
	}

	private function createPayment($order)
	{
	    $instruction = $order->getPaymentInstruction();
	    $pendingTransaction = $instruction->getPendingTransaction();

	    if ($pendingTransaction !== null) {
	        return $pendingTransaction->getPayment();
	    }

	    $ppc = $this->get('payment.plugin_controller');
	    $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

	    return $ppc->createPayment($instruction->getId(), $amount);
	}

	public function paymentCreateAction(Order $order)
	{
	    $payment = $this->createPayment($order);

	    $ppc = $this->get('payment.plugin_controller');
	    $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

		if ($result->getStatus() === Result::STATUS_PENDING) {
		    $ex = $result->getPluginException();

		    if ($ex instanceof ActionRequiredException) {
		        $action = $ex->getAction();

		        if ($action instanceof VisitUrl) {
		            return $this->redirect($action->getUrl());
		        }
		    }
		}

		// throw $result->getPluginException();

	    if ($result->getStatus() === Result::STATUS_SUCCESS) {
	        return $this->redirect($this->generateUrl('evangeliko_payment_complete', [
	            'id' => $order->getId(),
	        ]));
	    }

	    throw $result->getPluginException();

	    // In a real-world application you wouldn't throw the exception. You would,
	    // for example, redirect to the showAction with a flash message informing
	    // the user that the payment was not successful.
	}

	public function paymentCompleteAction(Order $order)
	{
		$em = $this->getDoctrine()->getManager();
		$credit = $order->getCredit();
		$amount = $order->getAmount();

		$credits = $em->getRepository("EvangelikoAccountBundle:CreditAmount")->findOneBy(['amt_pay' => $amount]);
		
		$balance = floatval($credit->getAmount()) + $credits->getPrice();

		$credit->setAmount($balance);
		$em->flush();

		$url = $this->generateUrl('evangeliko_credit_index');

		$this->addFlash('success', "Successfully bought credits.");

	    return new RedirectResponse($url);
	}
}