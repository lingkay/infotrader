<?php

namespace Evangeliko\CommunityBundle\Controller;

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

class CommunityController extends Controller
{
	protected $request;

	public function addPageAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$params['account'] = $this->getUser()->getAccount();

		$cts = $em->getRepository("EvangelikoCommunityBundle:CommunityType")->findAll();

		$ct_list = [];

		foreach ($cts as $ct) {
			$ct_list[$ct->getName()] = $ct->getName();
		}

		$params['page_type'] = $ct_list;

		$ints = $em->getRepository("EvangelikoAccountBundle:Interest")->findAll();

		$int_list = [];

		foreach ($ints as $int) {
			$int_list[$int->getName()] = $int->getName();
		}

		$params['interest'] = $int_list;

		$account = $this->getUser()->getAccount();

		$notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);

		$notif_list = [];

		foreach ($notifs as $notif) {
			$notif_list[] = $notif;
		}
		$params['notifs'] = $notif_list;

		$twig_file = "EvangelikoCommunityBundle:Community:create.html.twig";

		return $this->render($twig_file, $params);
	}

    public function listAction(Request $request)
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

        $twig_file = "EvangelikoCommunityBundle:Community:list.html.twig";

        return $this->render($twig_file, $params);
    }

	public function addSubmitAction(Request $request)
	{
		$this->request = $request;

		$data = $this->request->request->all();

		$em = $this->getDoctrine()->getManager();

        $account = $this->getUser()->getAccount();

		$community = new Community();

		try {
			$community->setName($data['page_name'])
		            ->setSlug($data['slug'])
		            ->setType($data['page_type'])
		            ->setDescription($data['description'])
		            ->setEnabled(true)
                    ->setInterests($data['interest'])
                    ->setCreator($account)
		            ->setUserCreate($this->getUser());

			$em->persist($community);

            foreach ($data['interest'] as $int) {
                $interest = $em->getRepository("EvangelikoAccountBundle:Interest")->findOneBy(['name' => $int]);

                $community_interest = new CommunityInterest();

                $community_interest->setUserCreate($this->getUser())
                                   ->setCommunity($community)
                                   ->setInterest($interest);

                $em->persist($community_interest);
            }

			$community_follower = new CommunityFollowers();

			$community_follower->setCommunity($community)
							   ->setFollower($this->getUser()->getAccount())
							   ->setStatus(CommunityFollowers::STATUS_FOLLOW);

			$em->persist($community_follower);
			$em->flush();

			$this->addFlash('success', 'Hive successfully created.');
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);
		} catch (ValidationException $e) {

			$this->addFlash('error', $e->getMessage());
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);	

		} catch (DBALException $e) {

			$this->addFlash('error', 'Database error encountered. Possible duplicate.');
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);

		}
	}

    public function editPageAction(Request $request, $slug)
    {
        $this->request = $request;

        $em = $this->getDoctrine()->getManager();

        $account = $this->getUser()->getAccount();

        $params['account'] = $account;

        $params['page'] = $em->getRepository("EvangelikoCommunityBundle:Community")->findOneBy(['slug' => $slug]);

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        $params['readonly'] = true;

        $ints = $em->getRepository("EvangelikoAccountBundle:Interest")->findAll();
        $int_list = [];
        foreach ($ints as $int) {
            $int_list[$int->getName()] = $int->getName();
        }
        $params['interest'] = $int_list;

        $pts = $em->getRepository("EvangelikoPostBundle:PostType")->findAll();

        $params['page_type'] = [
            'Free' => 'Public',
            'Private' => 'Private'
        ];

        $twig_file = "EvangelikoCommunityBundle:Community:create.html.twig";

        return $this->render($twig_file, $params);
    }

	public function editSubmitAction(Request $request, $slug)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->findOneBy(['slug' => $slug]);

		$data = $this->request->request->all();

		try {
			$community->setDescription($data['description']);

			$em->flush();

			$this->addFlash('success', 'Hive edited successfully.');
			$url = $this->request->headers->get("referer");
			return new RedirectResponse($url);	
		} catch (ValidationException $e) {

			$this->addFlash('error', $e->getMessage());
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);

		} catch (DBALException $e) {

			$this->addFlash('error', 'Database error encountered. Possible duplicate.');
			$url = $this->request->headers->get("referer");
			return new RedirectResponse($url);
		}
	}

    public function viewCommunityAction(Request $request, $slug, $filterType)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();

        $community = $em->getRepository("EvangelikoCommunityBundle:Community")->findOneBy(['slug' => $slug]);
        $params['page'] = $community;

        $twig_file = "EvangelikoCommunityBundle:Community:feed.html.twig";

        $filter_type = $filterType;
        $params['filter_type'] = $filter_type;

        $pts = $em->getRepository("EvangelikoPostBundle:PostType")->findAll();

        $pt_list = [];

        foreach ($pts as $pt) {
            $pt_list[$pt->getName()] = $pt->getName();
        }

        $params['post_type'] = $pt_list;

        $search_result = [];
        $params['search'] = $search_result;

        $account = $this->getUser()->getAccount();
        $params['account'] = $account;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        if ($filter_type == 'free' || $filter_type == 'paid'){
            if ($filter_type == 'free'){
                $filter_type = 'free';
            } elseif ($filter_type == 'paid'){
                $filter_type = 'Paid';
            }
            $posts = $em->getRepository('EvangelikoPostBundle:Post')
                ->findBy(
                    ["community" => $community,
                        "post_type" => $filter_type],
                    ['date_create' => "DESC"]
                );
        } elseif ($filter_type == 'read' ){
            $posts = $em->getRepository('EvangelikoPostBundle:Post')->createQueryBuilder('p')
                ->join('p.post_readers', 'pr')
                ->where('p.community = :community')
                ->setParameter('community', $community->getID())
                ->orderBy('p.date_create', 'DESC')
                ->getQuery()
                ->getResult();
        } else{
            $posts = $em->getRepository('EvangelikoPostBundle:Post')
                ->findBy(
                    array('community' => $community),
                    array('date_create' => 'DESC')
                );
        }

        $post_array = array();
        foreach ($posts as $post){
//            if ($post->getParent() == NULL) {
                $post_array[$post->getID()] = $post;
//            }
        }

        $params['posts'] = $post_array;

        return $this->render($twig_file, $params);
    }

	public function communityFollowAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$data = $this->request->request->all();

		$account = $this->getUser()->getAccount();

		try {
			$community_follow = new CommunityFollowers();

			$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($data['community_id']);

			$community_follow->setCommunity($community)
                                ->setFollower($account)
                                ->setUserCreate($this->getUser());

			if($community->getType() == 'Public'){
				$community_follow->setStatus(CommunityFollowers::STATUS_FOLLOW);

				$notif_owner = new Notification();

				$notif_owner->setRecipient($community->getUserCreate()->getAccount())
					        ->setMessage($account->getFullName()." followed ".$community->getName().' hive.');

				$notif_joiner = new Notification();

				$notif_joiner->setRecipient($this->getUser()->getAccount())
					         ->setMessage("You followed ".$community->getName().' hive.');

				$em->persist($notif_owner);
				$em->persist($notif_joiner);
			}else{
				$community_follow->getStatus(CommunityFollowers::STATUS_PENDING);

				$notif_owner = new Notification();

				$notif_owner->setRecipient($community->getUserCreate()->getAccount())
					        ->setMessage($account->getFullName()." wants to follow ".$community->getName().' hive.');

				$em->persist($notif_owner);
			}

			$em->persist($community_follow);
			$em->flush();

			if($community->getType() == 'Public'){
				$this->addFlash('success', $community->getName().' hive followed successfully.');
			}else{
				$this->addFlash('success', 'Request to follow '.$community->getName().' hive has been sent.');
			}

			$url = $this->request->headers->get("referer");
			return new RedirectResponse($url);

		} catch (ValidationException $e) {
			$this->addFlash('error', $e->getMessage());
	        $url = $this->request->headers->get("referer");
	        return new RedirectResponse($url);
		} catch (DBALException $e) {
			$this->addFlash('error', 'Database error encountered. Possible duplicate.');
			$url = $this->request->headers->get("referer");
			return new RedirectResponse($url);
		}
	}

	public function pendingInvitesAction(Request $request)
	{
		$this->request = $request;
		$em = $this->getDoctrine()->getManager();

		$twig_file = "EvangelikoCommunityBundle:Pending:index.html.twig";

		$user = $this->getUser()->getAccount();

        $pendings = $em->getRepository('EvangelikoCommunityBundle:CommunityFollowers')
                    ->findBy(
                		array('status' => "Pending", 'follower' => $user->getID())
            		);

        $list = [];

		foreach ($pendings as $pending) {
			$list[] = $pending;
		}

		$params['lists'] = $list;

        $query = $em->createQueryBuilder();
        $query->from('EvangelikoCommunityBundle:CommunityFollowers','o')
              ->join('EvangelikoCommunityBundle:Community','c','WITH','o.community = c.id')
              ->where('c.user_create = :user')
              ->andWhere('o.status = :pending')
              ->setParameter('pending', CommunityFollowers::STATUS_PENDING)
              ->setParameter('user',$this->getUser());

        $approvals = $query->select('o')
                           ->getQuery()
                           ->getResult();

        $app_list = [];

        foreach ($approvals as $approval) {
        	$app_list[] = $approval;
        }

        $params['approvals'] = $app_list;

		$params['object'] = $user;

		return $this->render($twig_file, $params);
	}

	public function acceptInvitesAction(Request $request)
	{
		$this->request = $request;
		$em = $this->getDoctrine()->getManager();

		$data = $this->request->request->all();

		$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['account_id']);

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($data['community_id']);

		$community_follow = $em->getRepository("EvangelikoCommunityBundle:CommunityFollowers")->findOneBy(['follower' => $account->getID(), 'community' => $data['community_id']]);

		$community_follow->setStatus(CommunityFollowers::STATUS_FOLLOW);

		if($data['approval']){
			$this->addFlash('success', 'Request to follow '.$community->getName()." hive is approved");

			$notif_joiner = new Notification();

			$notif_joiner->setRecipient($account)
					     ->setMessage("You are now following ".$community->getName().' hive.');

			$em->persist($notif_joiner);

		}else{
			$this->addFlash('success', $community->getName()." is now being Followed");

			$notif_joiner = new Notification();

			$notif_joiner->setRecipient($community->getUserCreate()->getAccount())
					     ->setMessage($account->getFullName()." follows ".$community->getName().' hive.');

			$em->persist($notif_joiner);
		}

		$em->flush();

		$url = $this->request->headers->get("referer");
		return new RedirectResponse($url);	
	}
}