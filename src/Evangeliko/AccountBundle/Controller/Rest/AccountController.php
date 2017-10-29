<?php

namespace Evangeliko\AccountBundle\Controller\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Core\TemplateBundle\Controller\BaseController;
use Evangeliko\AccountBundle\Entity\Account;
use Evangeliko\CommunityBundle\Entity\CommunityFollowers;

class AccountController extends BaseController
{
	/**
     * List all notes.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many notes to return.")
     *
     * @Annotations\View()
     */

    public function getAccountsAction(ParamFetcher $paramFetcher = null)
    {

        $em = $this->getDoctrine()->getManager();

        $limit = 100;
        $offset = 0;
        if($paramFetcher!=null){
            $offset = $paramFetcher->get('offset');
            $offset = null == $offset ? 0 : $offset; 
            $limit = $paramFetcher->get('limit'); 
            $limit = null == $limit ? 100 : $limit; 
            // $username = $paramFetcher->get('username'); 
            // $username = null == $username ? '' : $username; 
        }

        $users = $em->getRepository("EvangelikoAccountBundle:Account")->findBy([], null,$limit, $offset);

        return $this->view($users);
    }

	public function postAccountAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $this->request = $request();

        $user = $em->getRepository("CoreUserBundle:User")->find($this->request->get('user_create_id'));

        $account = new Account();

        $account->setFirstName($this->request->get('first_name'))
                ->setLastName($this->request->get('last_name'))
                ->setEmail($this->request->get('email'))
                ->setInterests($this->request->get('interest'))
                ->setUserCreate($user);

        $em->persist($account);
        $em->flush();

        return $this->view($user);
    }

    public function getAccountAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->findOneBy(['id' => $id]);
    	return $this->view($account);
    }

    /**
     * @QueryParam(name="first_name", nullable=true)
     * @QueryParam(name="offset", requirements="\d+", nullable=true)
     * @QueryParam(name="limit", requirements="\d+", default="10")
     */
    public function getAccountFirstnameSearchAction(ParamFetcher $paramFetcher){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("EvangelikoAccountBundle:Account")->findBy(["first_name" => $paramFetcher->get('first_name')],[],$paramFetcher->get('limit'),$paramFetcher->get('offset'));

        return $this->view($user);
    }

    /**
     * @QueryParam(name="first_name", nullable=true)
     * @QueryParam(name="offset", requirements="\d+", nullable=true)
     * @QueryParam(name="limit", requirements="\d+", default="10")
     */
    public function getAccountLastnameSearchAction(ParamFetcher $paramFetcher){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("EvangelikoAccountBundle:Account")->findBy(["last_name" => $paramFetcher->get('last_name')],[],$paramFetcher->get('limit'),$paramFetcher->get('offset'));

        return $this->view($user);
    }

    public function putAccountAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$this->request = $request;

    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($id);

    	if($account != NULL){
			$account->setFirstName($this->request->get('first_name'))
					->setLastName($this->request->get('last_name'))
					->setMobileNumber($this->request->get('mobile_number'))
					->setLandlineNumber($this->request->get('phone_number'))
					->setAbout($this->request->get('about_me'))
					->setInterests($this->request->get('interest'));    		

			$em->flush();

			return $this->view($account);
		}else{
			return $this->view($account,404);
		}
    }

    public function deleteAccountAction($id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($id);

    	if($account != NULL){
    		$em->remove($account);
    		$em->flush();

    		return "Delete Success.";
    	}else{
    		return $this->view($account, 404);
    	}
    }

    public function getAccountInvitesAction(Request $request, $account_id, $community_id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($account_id);
    	
    	$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($community_id);
    	$community_follower = $em->getRepository('EvangelikoCommunityBundle:CommunityFollowers')->findBy(['follower' => $account, 'community' => $community, 'status' => 'Pending']);

    	return $this->view($community_follower);
    }

    public function postAccountInviteAction(Request $request, $account_id, $community_id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($account_id);

    	$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($community_id);

    	$community_follower = new CommunityFollowers();

    	$community_follower->setFollower($account)
    					   ->setCommunity($community);

    	$em->persist($community_follower);
    	$em->flush();

    	return $this->view($community_follower);
    }

    public function putAccountInviteAction(Request $request, $account_id, $community_id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$this->request = $request;

    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($account_id);

    	$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($community_id);

    	$community_follower = $em->getRepository("EvangelikoCommunityBundle:CommunityFollowers")->findOneBy(['follower' => $account, 'community' => $community]);

    	if($community_follower != NULL){
    		$community_follower->setStatus($this->request->get('status'));
    		$em->flush();

    		return $this->view($community_follower);
    	}else{
    		return $this->view($community_follower, 404);
    	}
    }

    public function getAccountInviteAction(Request $request, $account_id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($account_id);
    	
    	$community_follower = $em->getRepository('EvangelikoCommunityBundle:CommunityFollowers')->findBy(['follower' => $account, 'status' => 'Pending']);

    	return $this->view($community_follower);
    }
}