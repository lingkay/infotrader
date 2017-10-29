<?php

namespace Evangeliko\AccountBundle\Controller\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Core\TemplateBundle\Controller\BaseController;
use Evangeliko\AccountBundle\Entity\Credit;

class CreditController extends BaseController implements ClassResourceInterface 
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
	public function cgetAction()
	{
		$em = $this->getDoctrine()->getManager();

        $limit = 100;
        $offset = 0;
        if($paramFetcher!=null){
            $offset = $paramFetcher->get('offset');
            $offset = null == $offset ? 0 : $offset; 
            $limit = $paramFetcher->get('limit'); 
            $limit = null == $limit ? 100 : $limit; 
        }

        $credits = $em->getRepository("EvangelikoAccountBundle:Credit")->findBy([], null,$limit, $offset);

        return $this->view($credits);
	}

	public function postAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$this->request = $request;

		$credit = new Credit();

		$account = $em->getRepository("EvangelikoAccountBundle:Account")->find($this->request->get('account'));

		$user = $em->getRepository("CoreUserBundle:User")->find($this->request->get('user_create_id'));

		$credit->setAccount($account)
			   ->setUserCreate($user);

		$em->persist($credit);
		$em->flush();

		return $this->view($credit);
	}

	public function getAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$credit = $em->getRepository("EvangelikoAccountBundle:Credit")->find($id);

		if($credit != NULL){
			return $this->view($credit);
		}else{
			return $this->view($credit,404);
		}
	}

	public function putAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$this->request = $request;

		$credit = $em->getRepository("EvangelikoAccountBundle:Credit")->find($id);

		if($credit != NULL){

			$credit->setAmount($this->request->get('amount'));
			$em->flush();

			return $this->view($credit);
		}else{
			return $this->view($credit,404);
		}
	}

	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$credit = $em->getRepository("EvangelikoAccountBundle:Credit")->find($id);

		if($credit != NULL){
			$em->remove($credit);
			$em->flush();

			return "Delete Success.";
		}else{
			return $this->view($credit,404);
		}

	}
}