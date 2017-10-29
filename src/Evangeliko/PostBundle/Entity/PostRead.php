<?php

namespace Evangeliko\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_post_read")
 */
class PostRead
{
    use TrackCreate;
    use HasGeneratedID;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Post", inversedBy="post_readers")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Account", inversedBy="post_read")
     * @ORM\JoinColumn(name="reader_id", referencedColumnName="id")
     */
    protected $reader;

    function __construct()
    {
        $this->initTrackCreate();
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

    public function setReader($reader)
    {
        $this->reader = $reader;
        return $this;
    }

    public function getReader()
    {
        return $this->reader;
    }

    public function toData()
    {
        $data = new stdClass;

        $this->dataHasGeneratedID($data);
        $data->post = $this->post->getID();
        $data->reader = $this->reader->toData();
        $this->dataTrackCreate($data);

        return $data;
    }
}