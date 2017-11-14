<?php
/**
 * Created by PhpStorm.
 * User: Cosmetigroup-web
 * Date: 30/10/2017
 * Time: 1:53 PM
 */

namespace Evangeliko\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\HasGeneratedID;

use stdClass;
/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_post_comment")
 */
class PostComment
{
    use HasGeneratedID;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Post", inversedBy="post_comment")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Comment", inversedBy="post_comment")
     * @ORM\JoinColumn(name="post_comment_id", referencedColumnName="id")
     */
    protected $comment;

    function __construct()
    {
    }

    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function toData()
    {
        $data = new stdClass;

        $this->dataHasGeneratedID($data);
        $data->post = $this->post->getID();
        $data->comment = $this->comment->toData();

        return $data;
    }
}