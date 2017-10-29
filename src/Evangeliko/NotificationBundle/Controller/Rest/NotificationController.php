<?php

namespace Evangeliko\NotificationBundle\Controller\Rest;

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
use Evangeliko\NotificationBundle\Entity\Notification;

class NotificationController extends BaseController implements ClassResourceInterface
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

        $notifications = $em->getRepository("EvangelikoNotificationBundle:Notification")->findBy([], null,$limit, $offset);

        return $this->view($notifications);
	}

	public function postAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

		$recipient = $em->getRepository("EvangelikoAccountBundle:Account")->find($this->request->request->get('account_id'));

        $notification = new Notification();

        $notification->setRecipient($recipient)
                     ->setMessage($this->request->request->get('message'))
                     ->setUserCreate($this->getUser());

        $em->persist($notification);
        $em->flush();

        return $this->view($notification);
	}

    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $notification = $em->getRepository("EvangelikoNotificationBundle:Notification")->find($id);

        if($notification != NULL){
            return $this->view($notification);
        }else{
            return $this->view($notification, 404);
        }
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $notification = $em->getRepository("EvangelikoNotificationBundle:Notification")->find($id);

        if($notification != NULL){
            $em->remove($notification);
            $em->flush();

            return "Delete Success.";
        }else{
            return $this->view($notification,404);
        }
    }
}