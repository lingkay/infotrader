<?php

namespace Evangeliko\PostBundle\Controller;

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
use Evangeliko\PostBundle\Entity\Post;
use Evangeliko\CommunityBundle\Entity\CommunityFollowers;

class PostController extends Controller
{
	protected $request;

    public function indexAction(Request $request, $slug)
    {
        $this->request = $request;

        $em = $this->getDoctrine()->getManager();

        $community = $em->getRepository("EvangelikoCommunityBundle:Community")->findOneBy(['slug' => $slug]);

        $twig_file = "EvangelikoCommunityBundle:Community:create_post.html.twig";

        $params['page'] = $community;

        $pts = $em->getRepository("EvangelikoPostBundle:PostType")->findAll();

        $pt_list = [];

        foreach ($pts as $pt) {
            $pt_list[$pt->getName()] = $pt->getName();
        }

        $params['post_type'] = $pt_list;

        $search_result = [];

        $params['search'] = $search_result;

        //added
        $account = $this->getUser()->getAccount();
        $params['account'] = $account;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;
        //

        return $this->render($twig_file, $params);
    }

    public function createUserPostAction(Request $request)
    {
        $this->request = $request;

        $em = $this->getDoctrine()->getManager();

        $twig_file = "EvangelikoAccountBundle:Profile:create_post.html.twig";

        $pts = $em->getRepository("EvangelikoPostBundle:PostType")->findAll();

        $pt_list = [];

        foreach ($pts as $pt) {
            $pt_list[$pt->getName()] = $pt->getName();
        }

        $params['post_type'] = $pt_list;

        $search_result = [];

        $params['search'] = $search_result;

        //added
        $account = $this->getUser()->getAccount();
        $params['account'] = $account;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;
        //

        return $this->render($twig_file, $params);
    }

    public function postAction(Request $request)
    {
        $this->request = $request;

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $data = $this->request->request->all();

        $post = new Post();
        if($data['account_type'] != 'user') {
            if($data['account_type'] == 'community'){
                $community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($data['community_id']);
                $post->setCommunity($community);

                $url = $this->generateUrl('evangeliko_community_view', array('slug' => $community->getSlug()));
            }else{
                $account = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['community_id']);
                $post->setAccount($account);
            }
        } else{
            $account = $user->getAccount();
            $url = $this->generateUrl('evangeliko_profile_index', array('id' => $account->getId()));
        }
        
        if(isset($data['post_type'])){
            $post->setPostType($data['post_type']);
            if($data['post_type'] == 'Paid'){
                $post->setAmount($data['amount']);
            }
        }

        if($data['parent'] != NULL){
            $parent = $em->getRepository("EvangelikoPostBundle:Post")->find($data['parent']);

            $post->setMessage($data['reply'])
                ->setTitle($parent->getTitle())
                ->setParent($parent);
        }else{
            $post->setMessage($data['post'])
                ->setTitle($data['post_title']);
        }

        $post->setUserCreate($this->getUser());

        $em->persist($post);
        $em->flush();

        return $this->redirect($url);
    }

    public function viewPostAction(Request $request)
    {
        $this->request = $request;
        $data = $this->request->query->all();
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($data['post_id']);
        $params['post'] = $post;
        $params['account'] = $this->getUser()->getAccount();

        $credit = $this->getUser()->getAccount()->getCredit();

        $amount = $credit->getAmount() - floatval($data['amount_modal']);

        $credit->setAmount($amount);

        $em->flush();

        $twig_file = 'EvangelikoCommunityBundle:Community:view_post.html.twig';

        return $this->render($twig_file, $params);
    }

	public function viewFreePostAction(Request $request, $id = null)
	{
		$this->request = $request;
		$em = $this->getDoctrine()->getManager();

		$post = $em->getRepository("EvangelikoPostBundle:Post")->find($id);
		$params['post'] = $post;
		$params['object'] = $this->getUser()->getAccount();

		$twig_file = 'EvangelikoCommunityBundle:Community:view_post.html.twig';

        return $this->render($twig_file, $params);
	}
}