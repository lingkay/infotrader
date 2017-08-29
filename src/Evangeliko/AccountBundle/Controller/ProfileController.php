<?php

namespace Evangeliko\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Doctrine\DBAL\DBALException;
use Core\ValidationException;

use Evangeliko\AccountBundle\Entity\Account;

class ProfileController extends Controller
{
	protected $request;

	public function indexAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();

		$params['object'] = $user->getAccount();

		$params['interest'] = [
            'cars' => 'Cars',
            'lifestyle' => 'Lifestyle',
            'finance' => 'Finance'
        ];

		$account = $this->getUser()->getAccount();

		$notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);

		$notif_list = [];

		foreach ($notifs as $notif) {
			$notif_list[] = $notif;
		}
		$params['notifs'] = $notif_list;

		$twig_file = "EvangelikoAccountBundle:Profile:index.html.twig";

		return $this->render($twig_file, $params);
	}

	public function profileEditAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$data = $this->request->request->all();

		$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['user']);
		try {
			$account->setFirstName($data['first_name'])
			        ->setLastName($data['last_name'])
			        ->setMobileNumber($data['mobile_number'])
			        ->setLandlineNumber($data['phone_number'])
			        ->setAbout($data['about_me'])
			        ->setInterests($data['interest']);

			$em->flush();

			$this->addFlash('success', 'Profile edited successfully.');
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);	
		} catch (ValidationException $e) {
	        $this->addFlash('error', $e->getMessage());
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);	
		} catch (DBALException $e){
			$this->addFlash('error', 'Database error encountered. Possible duplicate.');
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);
		}
	}
}