<?php

namespace Evangeliko\PostBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Core\UserBundle\Entity\User;
use Evangeliko\AccountBundle\Entity\Account;
use Evangeliko\PostBundle\Entity\Post;
use Evangeliko\PostBundle\Entity\Comment;
use Evangeliko\PostBundle\Entity\PostComment;

class CommentController extends Controller
{
    protected $request;

    public function commentAction(Request $request)
    {
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();
        $data = $this->request->request->all();

        $post = $em->getRepository("EvangelikoPostBundle:Post")->find($data['post_id']);
        $account = $this->getUser()->getAccount();

        if ($post){
            $comment = new Comment();
            $comment->setMessage($data['comment']);
            $comment->setCommenter($account);
            $em->persist($comment);
            $em->flush();

            if($comment){
                $post_comment = new PostComment();
                $post_comment->setPost($post);
                $post_comment->setComment($comment);
                $em->persist($post_comment);
                $em->flush();
            }

            $arrData = ['post_id' => $data['post_id'],
                        'comment' => $data['comment'],
                        'commenter' => $account->getFullName()];

            return new JsonResponse($arrData);
        }

        return $this->redirect($request->headers->get('referer'));
    }
}