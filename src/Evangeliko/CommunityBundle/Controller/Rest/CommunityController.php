<?php

namespace Evangeliko\CommunityBundle\Controller\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Core\TemplateBundle\Controller\BaseController;
use Evangeliko\CommunityBundle\Entity\Community;
use Evangeliko\CommunityBundle\Entity\CommunityFollowers;

class CommunityController extends BaseController
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
	public function getCommunitiesAction()
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

        $users = $em->getRepository("EvangelikoCommunityBundle:Community")->findBy([], null,$limit, $offset);

        return $this->view($users);
	}

	public function postCommunityAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$this->request = $request;

		$community = new Community();

		$community->setName($this->request->request->get('page_name'))
		          ->setSlug($this->request->request->get('slug'))
		          ->setType($this->request->request->get('page_type'))
		          ->setDescription($this->request->request->get('description'))
		          ->setEnabled(true)
		          ->setInterests($this->request->request->get('interest'))
		          ->setUserCreate($this->getUser());

		$em->persist($community);
		$em->flush();

		return $this->view($community);
	}

	public function getCommunityAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($id);

		if($community != NULL){
			return $this->view($community);
		}else{
			return $this->view($community, 404);
		}
	}

	public function putCommunityAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$this->request = $request;

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($id);

		if($community != NULL){
			$community->setDescription($this->request->request->get('description'));
		}
	}

	public function deleteCommunityAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($id);

		if($community != NULL){
			$em->remove($community);
			$em->flush();

			return "Delete Success.";
		}else{
			return $this->view($community,404);
		}
	}

	public function postCommunityFollowAction($account_id, $community_id)
	{
		$em = $this->getDoctrine()->getManager();

		$community = $em->getRepository("EvangelikoCommunityBundle:Community")->find($community_id);

		$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($account_id);

		$community_follower = $em->getRepository("EvangelikoCommunityBundle:CommunityFollowers")->findOneBy(['
			follower' => $account, 'community' => $community]);

		$community_follower->setFollower($account)
						   ->setCommunity($community);

		if($community->getType() == "Public"){
			$community_follower->setStatus(CommunityFollowers::STATUS_FOLLOW);
		}else{
			$community_follower->setStatus(CommunityFollowers::STATUS_PENDING);
		}

		$em->persist($community_follower);
		$em->flush();
	}
}