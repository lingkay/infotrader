<?php

namespace Evangeliko\AccountBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use Doctrine\DBAL\DBALException;
use Core\ValidationException;

use Evangeliko\AccountBundle\Entity\Order;
use Evangeliko\AccountBundle\Entity\Account;
use Evangeliko\AccountBundle\Entity\Credit;
use Evangeliko\AccountBundle\Entity\CreditHistory;

class CreditController extends Controller
{
	protected $request;

	public function indexAction(Request $request)
	{
		$this->request = $request;
		$data = $this->request->query->all();

		$em = $this->getDoctrine()->getManager();

		$params['account'] = $this->getUser()->getAccount();

		$amts = $em->getRepository("EvangelikoAccountBundle:CreditAmount")->findAll();

		$amt_list = [];

		$account = $this->getUser()->getAccount();

		$notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);

		$notif_list = [];

		foreach ($notifs as $notif) {
			$notif_list[] = $notif;
		}
		$params['notifs'] = $notif_list;

		// $session = $this->request->getSession();

		// $session->set('credit_redirect', $data['redirect_id']);

		if(isset($data['redirect_id'])){
			$params['redirect_id'] = $data['redirect_id'];
			$params['deduct'] = $data['amt_deduct'];
		}else{
			$params['redirect_id'] = 'false';
			$params['deduct'] = 0.00;
		}

		foreach ($amts as $amt) {
			$amt_list[$amt->getPayAmount()] = $amt->getPrice()." Credits ($".$amt->getPayAmount().")";
		}

		$params['amt_opts'] = $amt_list;

		$twig_file = "EvangelikoAccountBundle:Credit:index.html.twig";

		return $this->render($twig_file, $params);
	}

	public function submitAction(Request $request)
	{
		$this->request = $request;

		$data = $this->request->request->all();

		$em = $this->getDoctrine()->getManager();

		try {

			$acct_credit = $em->getRepository("EvangelikoAccountBundle:Credit")->find($data['account_credit_id']);

			if ($data['redirect'] != false) {
				$order = new Order($data['reload_amount'],$acct_credit, $data['redirect']);
			}else{
				$order = new Order($data['reload_amount'],$acct_credit, 0);
			}

			$em->persist($order);
			$em->flush();

			return $this->redirect($this->generateUrl('evangeliko_show_order', [
				'id' => $order->getId(),
			]));

			// $balance = floatval($acct_credit->getAmount()) + $data['reload_amount'];
			// $acct_credit->setAmount($balance);

			// $history = new CreditHistory();

			// $history->setCredit($acct_credit)
			        // ->setAmount($data['reload_amount'])
			        // ->setUserCreate($this->getUser());

			// $em->persist($history);
			// $em->flush();

			// $this->addFlash('success', "Credit reload complete.");

			// if($data['redirect'] != "false"){
			// 	$url = $this->generateUrl('evangeliko_view_free_post', array('id' => $data['redirect']));
			// 	$amount = floatval($data['reload_amount']) - floatval($data['amt_deduct']);

			// 	$acct_credit->setAmount($amount);

			// 	$em->flush();
			// }else{
	  //           $url = $this->request->headers->get("referer");
			// }

   //          return new RedirectResponse($url);  

        } catch (ValidationException $e) {
            $this->addFlash('error', $e->getMessage());
            $url = $this->request->headers->get("referer");
            return new RedirectResponse($url);   
        } catch (DBALException $e) {
            $this->addFlash('error', 'Database error encountered. Possible duplicate.');
            // $this->addFlash('error', $e->getMessage());

            $url = $this->request->headers->get("referer");
            return new RedirectResponse($url);
        }
	}
}