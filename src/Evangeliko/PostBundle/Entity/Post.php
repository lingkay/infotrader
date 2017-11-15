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

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\PostDetails", inversedBy="post")
     * @ORM\JoinColumn(name="post_details_id", referencedColumnName="id")
     */
    protected $post_details;

	/**
	 * @ORM\ManyToOne(targetEntity="Evangeliko\PostBundle\Entity\Post")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	protected $parent;

	/** @ORM\Column(type="integer", nullable=true) */
	protected $order_number;

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
     * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\PostRead", mappedBy="post")
     */
    protected $post_readers;

    /**
     * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\PostLikes", mappedBy="post")
     */
    protected $post_likes;

    /**
     * @ORM\OneToMany(targetEntity="Evangeliko\PostBundle\Entity\PostComment", mappedBy="post")
     */
    protected $post_comment;

	function __construct()
	{
		$this->initTrackCreate();
	}

    public function setPostDetails($post_details)
    {
        $this->post_details = $post_details;
        return $this;
    }

    public function getPostDetails()
    {
        return $this->post_details;
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

    public function getPostReaders()
    {
        return $this->post_readers;
    }

    public function getPostLikes()
    {
        return $this->post_likes;
    }

    public function getPostComment()
    {
        return $this->post_comment;
    }

	public function toData()
	{
		$data = new stdClass;

		$this->dataHasGeneratedID($data);

		$data->order = $this->order;

		$this->dataTrackCreate($data);

		return $data;
	}
}