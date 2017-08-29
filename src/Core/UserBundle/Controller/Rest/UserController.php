<?php

namespace Core\UserBundle\Controller\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Core\TemplateBundle\Controller\BaseController;
use Core\UserBundle\Entity\User;

class UserController extends BaseController
{
    protected $request;
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

    public function getUsersAction(ParamFetcher $paramFetcher = null)
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
        //Get all users with the same company;
        $users = $em->getRepository("CoreUserBundle:User")->findBy([], null,$limit, $offset);

        return $this->view($users);
    }

    public function postUsersAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $this->request = $request;
        $user = new User();
        $user->setUserName($this->request->get('username'))
            ->setPlainPassword($this->request->get('password'))
            ->setEmail($this->request->get('email'))
            ->setEnabled($this->request->get('enabled'));

        $em->persist($user);
        $em->flush();

        return $this->view($user);
    }
   
    public function getUserAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("CoreUserBundle:User")->findOneBy(['id'=> $id]);
        return $this->view($user);
    }

    /**
     * @QueryParam(name="username", nullable=true)
     * @QueryParam(name="offset", requirements="\d+", nullable=true)
     * @QueryParam(name="limit", requirements="\d+", default="10")
     */
    public function getUserSearchAction(ParamFetcher $paramFetcher){
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("CoreUserBundle:User")->findBy(["username" => $paramFetcher->get('username')],[],$paramFetcher->get('limit'),$paramFetcher->get('offset'));

        return $this->view($user);
    }

}