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
 * @ORM\Table(name="evangeliko_comment")
 */

class Comment
{
    use TrackCreate;
    use HasGeneratedID;

    /** @ORM\Column(type="text") */
    protected $comment;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Account", inversedBy="post_commented")
     * @ORM\JoinColumn(name="commenter_id", referencedColumnName="id")
     */
    protected $commenter;

    /**
     * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\PostComment", mappedBy="comment")
     */
    protected $post_comment;

    function __construct()
    {
        $this->initTrackCreate();
        $this->post_title = 0;
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

    public function setCommenter($commenter)
    {
        $this->commenter = $commenter;
        return $this;
    }

    public function getCommenter()
    {
        return $this->commenter;
    }

    public function getPostComment()
    {
        return $this->post_comment;
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

    public function getShortComment() {
        $pieces = explode(" ", $this->post_comment);
        $message = implode(" ", array_splice($pieces, 0, 15));

        return $message."...";
    }

    public function toData()
    {
        $data = new stdClass;

        $this->dataHasGeneratedID($data);

        $data->message = $this->message;

        $this->dataTrackCreate($data);

        return $data;
    }

}