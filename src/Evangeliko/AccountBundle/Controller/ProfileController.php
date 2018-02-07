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
use Evangeliko\AccountBundle\Entity\AccountFollowers;

use Evangeliko\NotificationBundle\Entity\Notification;

class ProfileController extends Controller
{
	protected $request;

    public function indexAction(Request $request, $username, $filterType)
    {
        $this->request = $request;

        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository("EvangelikoAccountBundle:Account")->findOneBy(['username' => $username]);
        $params['profile'] = $profile;

        $user = $em->getRepository("CoreUserBundle:User")->findOneBy(['account' => $profile->getId()]);
        $params['user'] = $user;

        $account = $this->getUser()->getAccount();
        $params['account'] = $account;

        $filter_type = $filterType;
        $params['filter_type'] = $filter_type;

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account], ['date_create' => 'desc'], 5);

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
                    ["community" => NULL,
                        "user_create" => $user->getId(),
                        "post_type" => $filter_type],
                    ['date_create' => "DESC"]
                );
        } elseif ($filter_type == 'sold'){
            $posts = $em->getRepository('EvangelikoPostBundle:Post')->createQueryBuilder('p')
//                ->join('p.post_readers', 'pr') //join to paid post
                ->where('p.community is NULL')
                ->andWhere('p.user_create = :user_create')
                ->setParameter('user_create', $user->getId())
                ->orderBy('p.date_create', 'DESC')
                ->getQuery()
                ->getResult();
        } elseif ($filter_type == 'read' ){
            $posts = $em->getRepository('EvangelikoPostBundle:Post')->createQueryBuilder('p')
                ->join('p.post_readers', 'pr')
                ->where('p.community is NULL')
                ->andWhere('p.user_create = :user_create')
                ->setParameter('user_create', $user->getId())
                ->orderBy('p.date_create', 'DESC')
                ->getQuery()
                ->getResult();
        } else{
            $posts = $em->getRepository('EvangelikoPostBundle:Post')
                ->findBy(
                    ["community" => NULL,
                        "user_create" => $user->getId()],
                    ['date_create' => "DESC"]
                );
        }

        $post_array = array();
        foreach ($posts as $post){
//            if ($post->getParent() == NULL) {
                $post_array[$post->getID()] = $post;
//            }
        }

        $params['posts'] = $post_array;

        $twig_file = "EvangelikoAccountBundle:Profile:index.html.twig";

        return $this->render($twig_file, $params);
    }

    public function profileAboutAction(Request $request)
    {

        $this->request = $request;
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $params['account'] = $user->getAccount();

        $params['interest'] = [
            'cars' => 'Cars',
            'lifestyle' => 'Lifestyle',
            'finance' => 'Finance'
        ];

        $account = $this->getUser()->getAccount();

        $notifs = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy(['recipient' => $account], ['date_create' => 'desc'], 5);
        $notif_list = [];
        foreach ($notifs as $notif) {
            $notif_list[] = $notif;
        }
        $params['notifs'] = $notif_list;

        $twig_file = "EvangelikoAccountBundle:Profile:about.html.twig";

        return $this->render($twig_file, $params);
    }

    public function profileSettingsAction(Request $request)
    {

        $this->request = $request;
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $params['account'] = $user->getAccount();

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

        $twig_file = "EvangelikoAccountBundle:Profile:settings.html.twig";

        return $this->render($twig_file, $params);
    }

	public function profileEditAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$data = $this->request->request->all();

		$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['user']);
		try {
            if (isset($data['username'])){
                $account->setUsername($data['username']);
            } else{
			    $account->setFirstName($data['first_name'])
			            ->setLastName($data['last_name'])
			            ->setMobileNumber($data['mobile_number'])
			            ->setLandlineNumber($data['phone_number'])
			            ->setAbout($data['about_me']);
            }


			if (isset($data['interest'])){
                $account->setInterests($data['interest']);
            }

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

    public function followAccountAction(Request $request)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();
        $data = $this->request->request->all();
        $account = $this->getUser()->getAccount();

        try {
            $profile = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['account_id']);
            $account_follow = $em->getRepository("EvangelikoAccountBundle:AccountFollowers")->findOneBy(['follower' => $account->getID(), 'account' => $data['account_id'], 'status' => 'Unfollowed']);

            if ($account_follow) {
                $account_follow->setEnabled(true);
            } else{
                $account_follow = new AccountFollowers();
                $account_follow->setAccount($profile)
                    ->setFollower($account)
                    ->setUserCreate($this->getUser());
            }

            $account_follow->setStatus(AccountFollowers::STATUS_FOLLOW);

            $notif_owner = new Notification();

            $notif_owner->setRecipient($profile)
                ->setMessage($account->getFullName()." followed you.")
                ->setAccount($profile);

            $notif_joiner = new Notification();

            $notif_joiner->setRecipient($this->getUser()->getAccount())
                ->setMessage("You followed ".$profile->getFullName().' hive.')
                ->setAccount($profile);

            $em->persist($notif_owner);
            $em->persist($notif_joiner);

//            if($community->getType() == 'Public'){
//                $community_follow->setStatus(CommunityFollowers::STATUS_FOLLOW);
//
//                $notif_owner = new Notification();
//
//                $notif_owner->setRecipient($community->getUserCreate()->getAccount())
//                    ->setMessage($account->getFullName()." followed ".$community->getName().' hive.')
//                    ->setCommunity($community);
//
//                $notif_joiner = new Notification();
//
//                $notif_joiner->setRecipient($this->getUser()->getAccount())
//                    ->setMessage("You followed ".$community->getName().' hive.')
//                    ->setCommunity($community);
//
//                $em->persist($notif_owner);
//                $em->persist($notif_joiner);
//            }else{
//                $community_follow->getStatus(CommunityFollowers::STATUS_PENDING);
//
//                $notif_owner = new Notification();
//
//                $notif_owner->setRecipient($community->getUserCreate()->getAccount())
//                    ->setMessage($account->getFullName()." wants to follow ".$community->getName().' hive.')
//                    ->setCommunity($community);
//
//                $em->persist($notif_owner);
//            }

            $em->persist($account_follow);
            $em->flush();

            $this->addFlash('success', $profile->getFullName().' followed successfully.');

//            if($profile->getType() == 'Public'){
//                $this->addFlash('success', $profile->getFullName().' hive followed successfully.');
//            }else{
//                $this->addFlash('success', 'Request to follow '.$profile->getFullName().' hive has been sent.');
//            }

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

    public function unfollowAccountAction(Request $request)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();
        $data = $this->request->request->all();
        $account = $this->getUser()->getAccount();

        try {
            $profile = $em->getRepository("EvangelikoAccountBundle:Account")->find($data['account_id']);
            $account_follow = $em->getRepository("EvangelikoAccountBundle:AccountFollowers")->findOneBy(['follower' => $account->getID(), 'account' => $data['account_id'], 'status' => 'Followed']);

            $account_follow->setEnabled(false);
            $account_follow->setStatus(AccountFollowers::STATUS_UNFOLLOW);
            $em->persist($account_follow);
            $em->flush();

//           delete notification

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
}