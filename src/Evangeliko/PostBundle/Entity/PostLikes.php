<?php

namespace Evangeliko\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasEnabled;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_post_likes")
 */
class PostLikes
{
    use TrackCreate;
    use HasGeneratedID;
    use HasEnabled;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Post", inversedBy="post_likes")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Account", inversedBy="post_liked")
     * @ORM\JoinColumn(name="liker_id", referencedColumnName="id")
     */
    protected $liker;

    function __construct()
    {
        $this->initTrackCreate();
        $this->initHasEnabled();
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

    public function setLiker($liker)
    {
        $this->liker = $liker;
        return $this;
    }

    public function getLiker()
    {
        return $this->liker;
    }

    public function toData()
    {
        $data = new stdClass;

        $this->dataHasGeneratedID($data);
        $data->post = $this->post->getID();
        $data->liker = $this->liker->toData();
        $this->dataHasEnabled($data);
        $this->dataTrackCreate($data);

        return $data;
    }
}