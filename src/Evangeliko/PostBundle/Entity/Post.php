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
 * @ORM\Table(name="evangeliko_posts")
 */

class Post
{
	use TrackCreate;
	use HasGeneratedID;

	/** @ORM\Column(type="text") */
	protected $post_title;

	/** @ORM\Column(type="text") */
	protected $post_message;

	/**
	 * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Post")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	protected $parent;

	/** @ORM\Column(type="integer", nullable=true) */
	protected $order_number;

	/** @ORM\Column(type="string", length=20) */
	protected $post_type;

	/** @ORM\Column(type="decimal", precision=10, scale=2, nullable=true) */
	protected $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Uploads")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    protected $file;

	/**
	 * @ORM\ManyToOne(targetEntity="Evangeliko\CommunityBundle\Entity\Community", inversedBy="post")
	 * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
	 */
	protected $community;

	/**
	 * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Account", inversedBy="post")
	 * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
	 */
	protected $account;

	/**
	 * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\Post", mappedBy="parent")
	 */
	protected $reply;

    /**
     * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\PostRead", mappedBy="post")
     */
    protected $post_readers;

    /**
     * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\PostLikes", mappedBy="post")
     */
    protected $post_likes;

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

	public function setParent($parent)
	{
		$this->parent = $parent;
		return $this;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function setOrder($order_number)
	{
		$this->order_number = $order_number;
		return $this;
	}

	public function getOrder()
	{
		return $this->order_number;
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

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getUploadDate()
    {
        return $this->getFile()->updatedAt->format("m-d-Y");
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

    public function setAccount($account)
    {
    	$this->account = $account;
    	return $this;
    }

    public function getAccount()
    {
    	return $this->account;
    }

    public function getReply()
    {
    	return $this->reply;
    }

    public function getPostReaders()
    {
        return $this->post_readers;
    }

    public function getPostLikes()
    {
        return $this->post_likes;
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
		$data->order = $this->order;
		$data->post_type = $this->post_type;
		$data->amount = $this->amount;

		$this->dataTrackCreate($data);

		return $data;
	}
}