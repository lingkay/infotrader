<?php

namespace Evangeliko\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasEnabled;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_notifications")
 */

class Notification
{
	use TrackCreate;
	use HasGeneratedID;
	use HasEnabled;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Account")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     */
    protected $source;

	/**
	 * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Account")
	 * @ORM\JoinColumn(name="recipient_id", referencedColumnName="id")
	 */
	protected $recipient;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\CommunityBundle\Entity\Community")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
     */
    protected $community;

	/** @ORM\Column(type="string") */
	protected $message;

	function __construct()
	{
		$this->initTrackCreate();
		$this->initHasEnabled();
	}

    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

	public function setRecipient($recipient)
	{
		$this->recipient = $recipient;
		return $this;
	}

	public function getRecipient()
	{
		return $this->recipient;
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

    public function setCommunity($community)
    {
        $this->community = $community;
        return $this;
    }

    public function getCommunity()
    {
        return $this->community;
    }

	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}

	public function getMessage()
	{
		return $this->message;
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

	public function toData()
	{
		$data = new stdClass();

		return $data;
	}
}