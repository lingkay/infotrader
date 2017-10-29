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

use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use JMS\Payment\CoreBundle\Entity\ExtendedData;

/**
 * @Route("/orders")
 */
class OrdersController extends Controller
{
	/**
     * @Route("/new/{amount}")
     */
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

	/**
	 * @Route("/{id}/show")
	 * @Template
	 */
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
		        'cancel_url' => "http://socialmedia.purltech.com/credit",
		    ],
		];

	   $router = $this->get('router');

	    // Create the extended data object
	    $extendedData = new ExtendedData();

	    // Complete payment return URL
	    $extendedData->set('return_url',
	        $router->generate('app_orders_paymentcreate', array(
	            'id' => $order->getId(),
	        ), true)
	    );

	    // Cancel payment return URL
	    $extendedData->set('cancel_url',
	        $router->generate('evangeliko_account_index', [], true)
	    );


	    // Add checkout information to the exended data
	    $extendedData->set('checkout_params', []);

	    // Create the payment instruction object
	    $instruction = new PaymentInstruction(
	        $order->getAmount(), 'USD', 'paypal_express_checkout', $extendedData
	    );

	    $this->get('payment.plugin_controller')->createPaymentInstruction($instruction);

		$order->setPaymentInstruction($instruction);

		$em = $this->getDoctrine()->getManager();
		$em->persist($order);
		$em->flush($order);

		return $this->redirect($this->generateUrl('app_orders_paymentcreate', [
			'id' => $order->getId(),
		]));
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

	/**
	 * @Route("/{id}/payment/create")
	 */
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

		if($order->getRedirectID() != 0){
			$post = $em->getRepository("EvangelikoPostBundle:Post")->find($order->getRedirectID());
			$url = $this->generateUrl('evangeliko_view_free_post', array('id' => $post->getID()));

			$amount = floatval($balance) - floatval($post->getAmount());

			$credit->setAmount($amount);

			$em->flush();
			$this->addFlash('success', "Thank you and enjoy reading");
		}else{
			$this->addFlash('success', "Successfully bought credits.");
            $url = $this->generateUrl('evangeliko_account_index');
		}

	    return new RedirectResponse($url);
	}
}