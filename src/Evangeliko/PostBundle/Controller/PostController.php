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
use Evangeliko\PostBundle\Entity\Uploads;
use Evangeliko\PostBundle\Entity\PostRead;
use Evangeliko\PostBundle\Entity\PostLikes;
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
        $params['account'] = $this->getUser()->getAccount();

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

    public function createUserPostAction(Request $request, $username)
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

                $url = $this->generateUrl('evangeliko_community_view', array('slug' => $community->getSlug(), 'filterType' => 'all'));
            }else{
                $account = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['community_id']);
                $post->setAccount($account);
            }
        } else{
            $account = $user->getAccount();
            $url = $this->generateUrl('evangeliko_profile_index', array('username' => $account->getUsername(), 'filterType' => 'all'));
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
                ->setPostType('free')
                ->setParent($parent);

//            $url = $this->generateUrl('evangeliko_view_free_post', array('id' => $parent->getID()));
            $url = $request->headers->get('referer');
//            return new RedirectResponse($referer);
        }else{
            $post->setMessage($data['post'])
                ->setTitle($data['post_title']);
        }

        $files = $request->files->get('post_file');
        if ($files) {
            $file = new Uploads();
            $file->setImageName($data['post_title']);
            $file->setImageFile($files);
            $em->persist($file);
            $em->flush();
            $post->setFile($file);
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

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($data['id']);
        $params['post'] = $post;
        $account = $this->getUser()->getAccount();
        $params['account'] = $account;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        $credit = $this->getUser()->getAccount()->getCredit();

        $amount = $credit->getAmount() - floatval($data['amount_modal']);

        $credit->setAmount($amount);

        $em->flush();

        // $twig_file = 'EvangelikoCommunityBundle:Community:view_post.html.twig';

        $url = $this->generateUrl('evangeliko_view_free_post', array('id' => $post->getID()));
        return new RedirectResponse($url);
        // return $this->render($twig_file, $params);
    }

	public function viewFreePostAction(Request $request, $id = null)
	{
		$this->request = $request;
		$em = $this->getDoctrine()->getManager();

		$post = $em->getRepository("EvangelikoPostBundle:Post")->find($id);
		$params['post'] = $post;
        $account = $this->getUser()->getAccount();
		$params['account'] = $account;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        if ($post){
            $exist_post_read = $em->getRepository("EvangelikoPostBundle:PostRead")->findBy(['post' => $post->getID(), 'reader' => $account->getID()]);
            if(!$exist_post_read){
                $reader = new PostRead();
                $reader->setPost($post);
                $reader->setReader($account);
                $em->persist($reader);
                $em->flush();
            }
        }

		$twig_file = 'EvangelikoCommunityBundle:Community:view_post.html.twig';

        return $this->render($twig_file, $params);
	}

    public function viewPaidPostAction(Request $request, $id = null)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($id);
        $params['post'] = $post;
        $account = $this->getUser()->getAccount();
        $params['account'] = $account;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account]);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        $twig_file = 'EvangelikoPostBundle:Post:view_paid_post.html.twig';

        return $this->render($twig_file, $params);
    }

    public function likePostAction(Request $request)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();
        $data = $this->request->request->all();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($data['id']);
        $account = $this->getUser()->getAccount();

        if ($post){
            $exist_post_like = $em->getRepository("EvangelikoPostBundle:PostLikes")->findOneBy(['post' => $post->getID(), 'liker' => $account->getID()]);

            if($exist_post_like){
                $exist_post_like->setEnabled(true);
                $em->flush();
            } else{
                $like_post = new PostLikes();
                $like_post->setPost($post);
                $like_post->setLiker($account);
                $em->persist($like_post);
                $em->flush();
            }

            $arrData = ['output' => $post->getID()];
            return new JsonResponse($arrData);
        }

        return $this->render("/"); //redirect to index chaagne rredirect
    }

    public function unlikePostAction(Request $request)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();
        $data = $this->request->request->all();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($data['id']);
        $account = $this->getUser()->getAccount();

        if ($post){
            $exist_post_like = $em->getRepository("EvangelikoPostBundle:PostLikes")->findOneBy(['post' => $post->getID(), 'liker' => $account->getID()]);

            if($exist_post_like){
                $exist_post_like->setEnabled(false);
                $em->flush();
            }

            $arrData = ['output' => $post->getID()];
            return new JsonResponse($arrData);
        }

        return $this->render("/"); //redirect to index chaagne rredirect
    }
}