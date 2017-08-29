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
use Evangeliko\AccountBundle\Entity\CreditHistory;

class HistoryController extends BaseController implements ClassResourceInterface
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

	public function cgetAction($credit_id)
	{
		$em = $this->getDoctrine()->getManager();
		$chs = $em->getRepository('EvangelikoAccountBundle:CreditHistory')->findBy(['credit' => $credit_id]);

		if($chs != null) {
			return $this->view($chs);
		} else {
			$chs = $em->getRepository('EvangelikoAccountBundle:Credit')->find($credit_id);
			return $this->view($chs);
		}
	}

	public function postAction(Request $request, $credit_id)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$credit = $em->getRepository("EvangelikoAccountBundle:Credit")->find($credit_id);

		$ch = new CreditHistory();

		$ch->setCredit($credit)
		   ->setAmount($this->request->get('amount'))
		   ->setUserCreate($this->getUser());

		$em->persist($ch);
		$em->flush();

		return $this->view($ch);
	}

	public function getAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$ch = $em->getRepository("EvangelikoAccountBundle:CreditHistory")->find($id);

		if($ch != NULL){
			return $this->view($ch);
		}else{
			return $this->view($ch, 404);
		}
	}
}