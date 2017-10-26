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

use Core\UserBundle\Entity\User;
use Evangeliko\AccountBundle\Entity\Account;
use Evangeliko\AccountBundle\Entity\Post;
use Evangeliko\CommunityBundle\Entity\CommunityFollowers;
use Evangeliko\NotificationBundle\Entity\Notification;

use DateTime;

class AccountController extends Controller
{
	protected $request;

    public function indexAction(Request $request)
    {
        $this->request = $request;

        $user = $this->getUser();

        $params['account'] = $user->getAccount();
        $params['user'] = $user;

        $em = $this->getDoctrine()->getManager();

        $params['post_type'] = [
            'free' => 'Free',
            'paid' => 'Paid'
        ];

        // $community = $em->getRepository("EvangelikoCommunityBundle:Community")->createQueryBuilder("o")
        //                 ->where('o.type = :public')
        //                 ->setParameter("public", "public")
        //                 ->getQuery()
        //                 ->getResult();

        $community = $em->getRepository("EvangelikoCommunityBundle:Community")->findAll();

        $community_list = [];

        $community_followed = [];

        foreach ($user->getAccount()->getCommunityFollowed() as $follow) {
            $community_followed[] = $follow->getCommunity()->getID();
        }

        foreach ($community as $c) {
            if(!in_array($c->getID(), $community_followed)){
                if(!empty(array_intersect($user->getAccount()->getInterests(), $c->getInterests()))){
                    $community_list[] = $c->toData();
                }
            }
        }

        $params['communities'] = $community_list;

        $posts = $em->getRepository('EvangelikoPostBundle:Post')
            ->findBy(
                [],
                array('date_create' => 'DESC')
            );
        $post_array = array();
        foreach ($posts as $post){
            if ($post->getParent() == NULL) {
                $post_array[$post->getID()] = $post;
            }
        }

        $params['posts'] = $post_array;

        $account = $this->getUser()->getAccount();

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);

        $notif_list = [];

        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        $twig_file = 'EvangelikoAccountBundle:Account:index.html.twig';

        return $this->render($twig_file, $params);
    }

	public function ajaxPostAction(Request $request)
	{
		$this->request = $request;

		$user = $this->getUser();

		$em = $this->getDoctrine()->getManager();

		$data = $this->request->request->all();

		$post = new Post();

		if($data['account_type'] == 'community'){
			$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($data['community_id']);
			$post->setCommunity($community);
		}else{
			$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['community_id']);
			$post->setAccount($account);
		}

		if(isset($data['post_type'])){
			$post->setPostType($data['post_type']);
			if($data['post_type'] == 'paid'){
				$post->setAmount($data['amount']);
			}
		}

		if($data['parent'] != NULL){
			$parent = $em->getRepository("EvangelikoAccountBundle:Post")->find($data['parent']);

			$post->setMessage($data['reply'])
			     ->setParent($parent);
		}else{
			$post->setMessage($data['post']);
		}

		    $post->setUserCreate($this->getUser());

		$em->persist($post);
		$em->flush();

        $url = $this->request->headers->get("referer");
        return new RedirectResponse($url);
	}

	public function searchPeopleAction(Request $request)
	{
		$this->request = $request;
		$data = $this->request->request->all();
		$em = $this->getDoctrine()->getManager();

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->findOneBy(['slug' => $data['slug']]);

		$contacts = $em->getRepository('EvangelikoAccountBundle:Account')->createQueryBuilder('o')
		               ->where('o.first_name LIKE :first')
			           ->orwhere('o.last_name LIKE :last')
			           ->setParameter('first',"%".$data['search_name']."%")
			           ->setParameter('last',"%".$data['search_name']."%")
			           ->getQuery()
				       ->getResult();

		$followers = $community->getFollowers();

		$following = [];

		foreach ($followers as $account) {
			$following[] = $account->getFollower()->getID();
		}

		$search_result = [];

		foreach ($contacts as $contact) {
			if(!in_array($contact->getID(), $following)){
				$search_result[] = $contact;
			}
		}

		$params['search'] = $search_result;

		$params['object'] = $community;

		$params['post_type'] = [
			'free' => 'Free',
			'paid' => 'Paid'
		];

        $posts = $em->getRepository('EvangelikoPostBundle:Post')
                    ->findBy(
                		array('community' => $community),
                		array('date_create' => 'DESC')
            		);
        $post_array = array();
        foreach ($posts as $post){
        	if ($post->getParent() == NULL) {
	        	$post_array[$post->getID()] = $post;
        	}
        }

        $params['posts'] = $post_array;

        $twig_file = "EvangelikoCommunityBundle:Community:view.html.twig";

		return $this->render($twig_file, $params);
	}

	public function invitePeopleAction(Request $request, $id = null, $community = null)
	{
		$this->request = $request;
		$em = $this->getDoctrine()->getManager();

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($community);
		$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($id);

		$community_follower = new CommunityFollowers();

		$community_follower->setCommunity($community)
						   ->setFollower($account)
						   ->setStatus("Pending");

		$em->persist($community_follower);

		$notif_joiner = new Notification();

		$notif_joiner->setRecipient($account)
			         ->setMessage($this->getUser()->getAccount()->getFullName()." recommended ".$community->getName().' hive.');

		$em->persist($notif_joiner);

		$em->flush();

		$this->addFlash("success", "Invitation Sent.");
        $url = $this->generateUrl('evangeliko_community_view', array('slug' => $community->getSlug()));
        return new RedirectResponse($url);
	}

	public function ajaxFilterAccountAction(Request $request)
    {
        $this->request = $request;
        $data = $this->request->query->all();
        $em = $this->getDoctrine()->getManager();
        $query = $data['query'];

        $list_opts = [];
        $employees = $em->getRepository("EvangelikoAccountBundle:Account")->createQueryBuilder('o')
           ->where('o.first_name LIKE :first_name')
           ->orWhere('o.last_name LIKE :last_name')
           ->setParameter('first_name', "%".$query."%")
           ->setParameter('last_name', "%".$query."%")
           ->getQuery()
           ->getResult();

        
        foreach ($employees as $employee) {
            $list_opts[] = array('id'=>$employee->getID(), 'name'=> $employee->getFullName());
        }

        $communities = $em->getRepository("EvangelikoCommunityBundle:Community")->createQueryBuilder('o')
                          ->where('o.name LIKE :community')
                          ->setParameter('community', "%".$query."%")
                          ->getQuery()
                          ->getResult();

        foreach ($communities as $community) {
            $list_opts[] = ['id' => $community->getID(), 'name' => $community->getName()];
        }

        $employees = $em->getRepository("CoreUserBundle:User")->createQueryBuilder('o')
                    ->where('o.username LIKE :username')
                    ->setParameter('username', "%".$query."%")
                    ->getQuery()
                    ->getResult();

        foreach ($employees as $employee) {
            $list_opts[] = array('id'=>$employee->getID(), 'name'=> $employee->getUsername()."(".substr($employee->getName(),0,6).")");
        }

        if(empty($list_opts)) {
            $list_opts[] = ['id' => "", 'name' => "No Search Result for ".$query];
        }
        return new JsonResponse($list_opts);
    }

    public function redirectAction($id,$name)
    {


        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository("EvangelikoAccountBundle:Account")->find($id);

        if($data != null) {
            if($data->getFullName() == $name) {
                $url = $this->generateUrl("evangeliko_profile_index", ['username' => $data->getUsername(), 'filterType' => 'all']);
                return new JsonResponse($url);
            }
        }

        $data = $em->getRepository("EvangelikoCommunityBundle:Community")->find($id);

        if($data != NULL){
            if($data->getName() == $name) {
                $url = $this->generateUrl('evangeliko_community_view', array('slug' => $data->getSlug(), 'filterType' => 'all'));
                return new JsonResponse($url);
            }
        }

        $data = $em->getRepository("CoreUserBundle:User")->find($id);

        if($data != NULL){
            $trimName = explode("(",$name);
            $trimName = trim($trimName[0]);

            if($data->getUsername() == $trimName){
                $url = $this->generateUrl("evangeliko_profile_index", ['username' => $data->getAccount()->getUsername()]);
                return new JsonResponse($url);
            }
        }
    }
}