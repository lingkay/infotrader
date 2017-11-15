<?php

namespace Evangeliko\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\TrackCreate;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_post_details")
 */

class PostDetails
{
    use TrackCreate;
    use HasGeneratedID;

    /**
     * @ORM\OneToMany(targetEntity="\Evangeliko\PostBundle\Entity\Post", mappedBy="post_details")
     */
    protected $post;

    /** @ORM\Column(type="text") */
    protected $post_title;

    /** @ORM\Column(type="text") */
    protected $post_message;


    /** @ORM\Column(type="string", length=20) */
    protected $post_type;

    /** @ORM\Column(type="decimal", precision=10, scale=2, nullable=true) */
    protected $amount;

    function __construct()
    {
        $this->initTrackCreate();
        $this->amount = 0;
        $this->post_type = 'free';
    }

    public function setTitle($title)
    {
        $this->post_title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->post_title;
    }

    public function setMessage($post_message)
    {
        $this->post_message = $post_message;
        return $this;
    }

    public function getMessage()
    {
        return $this->post_message;
    }

    public function setPostType($post_type)
    {
        $this->post_type = $post_type;
        return $this;
    }

    public function getPostType()
    {
        return $this->post_type;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTimePassed()
    {
        $current = new Datetime();
        $passed = $current->diff($this->date_create);

        if($passed->y > 0){
            return $passed->y." year(s) ago";
        }
        if($passed->m > 0){
            return $passed->m." month(s) ago";
        }
        if($passed->d > 0){
            return $passed->d." day(s) ago";
        }
        if($passed->h > 0){
            return $passed->h." hour(s) ago";
        }
        if($passed->i > 0){
            return $passed->i." minute(s) ago";
        }
        if($passed->s > 0){
            return $passed->s." second(s) ago";
        }
    }

    public function getShortMessage() {
        $pieces = explode(" ", $this->post_message);
        $message = implode(" ", array_splice($pieces, 0, 15));

        return $message."...";
    }

    public function toData()
    {
        $data = new stdClass;

        $this->dataHasGeneratedID($data);

        $data->message = $this->message;
        $data->parent = $this->parent;
        $data->post_type = $this->post_type;
        $data->amount = $this->amount;

        $this->dataTrackCreate($data);

        return $data;
    }
}