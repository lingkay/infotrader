<?php

namespace Evangeliko\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Doctrine\DBAL\DBALException;
use Core\ValidationException;

use Evangeliko\CommunityBundle\Entity\Community;
use Evangeliko\CommunityBundle\Entity\CommunityInterest;
use Evangeliko\CommunityBundle\Entity\CommunityFollowers;

use Evangeliko\NotificationBundle\Entity\Notification;

class NotificationController extends Controller
{
	protected $request;

	public function indexAction(Request $request)
	{
		$this->request = $request;

		$account = $this->getUser()->getAccount();

		$em = $this->getDoctrine()->getManager();

        $params['account']= $account;

		$notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);

		$notif_list = [];

		foreach ($notifs as $notif) {
			$notif_list[] = $notif;
		}

		$params['notifs'] = $notif_list;

		$twig_file = "EvangelikoNotificationBundle:Notification:index.html.twig";

		return $this->render($twig_file, $params);
	}
}