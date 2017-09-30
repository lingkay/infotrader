<?php

namespace Evangeliko\PostBundle\Controller\Rest;

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
use Evangeliko\PostBundle\Entity\Post;

class PostController extends BaseController implements ClassResourceInterface
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

        $posts = $em->getRepository("EvangelikoPostBundle:Post")->findBy([], null,$limit, $offset);

        return $this->view($posts);
	}

	public function postAction(Request $request)
	{
		$this->request = $request;

		$em = $this->getDoctrine()->getManager();

        $post = new Post();

        $post->setTitle($this->request->request->get('post_title'))
             ->setMessage($this->request->request->get('post_message'))
             ->setPostType($this->request->request->get('post_type'))
             ->setAmount($this->request->request->get('post_amount'));

        $em->persist($post);
        $em->flush();

        return $this->view($post);
	}

    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($id);

        if($post != NULL){
            return $this->view($post);
        }else{
            return $this->view($post, 404);
        }
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($id);

        if($post != NULL){
            $em->remove($post);
            $em->flush();

            return "Delete Success.";
        }else{
            return $this->view($post,404);
        }
    }
}