<?php

namespace Evangeliko\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasEnabled;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_account")
 */

class Account
{
	use TrackCreate;
	use HasGeneratedID;
	use HasEnabled;

	/** @ORM\Column(type="string", length=80) */
	protected $first_name;

	/** @ORM\Column(type="string", length=80) */
	protected $last_name;

	/** @ORM\Column(type="string", length=80) */
	protected $email;

	/** @ORM\Column(type="string", length=20, nullable=true) */
	protected $mobile_no;

	/** @ORM\Column(type="string", length=20, nullable=true) */
	protected $landline_no;	

	/** @ORM\Column(type="string", length=100, nullable=true) */
	protected $about;

    /** @ORM\Column(type="string", length=30) */
    protected $username;

    /** @ORM\OneToMany(targetEntity="\Evangeliko\AccountBundle\Entity\AccountInterest", mappedBy="account") */
	protected $interest;

	/**
	 * @ORM\OneToMany(targetEntity="\Evangeliko\AccountBundle\Entity\Friendship", mappedBy="account")
	 */
	protected $friends;

	/**
	 * @ORM\OneToMany(targetEntity="\Evangeliko\AccountBundle\Entity\Friendship", mappedBy="friend")
	 */
	protected $account;

	/**
	 * @ORM\OneToMany(targetEntity="\Evangeliko\CommunityBundle\Entity\CommunityFollowers", mappedBy="follower")
	 */
	protected $community;

    /**
     * @ORM\OneToOne(targetEntity="\Core\UserBundle\Entity\User", mappedBy="account", cascade={"persist"})
     */
    protected $user;

    /** @ORM\Column(type="json_array") */
    protected $interests;

    /**
     * @ORM\OneToMany(targetEntity="\Evangeliko\PostBundle\Entity\Post", mappedBy="account")
     */
    protected $post;

    /**
     * @ORM\OneToMany(targetEntity="\Evangeliko\PostBundle\Entity\PostRead", mappedBy="reader")
     */
    protected $post_read;

    /**
     * @ORM\OneToMany(targetEntity="\Evangeliko\PostBundle\Entity\PostLikes", mappedBy="liker")
     */
    protected $post_liked;

    /**
     * @ORM\OneToMany(targetEntity="\Evangeliko\PostBundle\Entity\PostComment", mappedBy="commenter")
     */
    protected $post_commented;

	/**
	 * @ORM\OneToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Credit", mappedBy="account")
	 */
	protected $credit;

	function __construct()
	{
		$this->initTrackCreate();
		$this->initHasEnabled();
	}

	public function setFirstName($first_name)
	{
		$this->first_name = $first_name;
		return $this;
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function setLastName($last_name)
	{
		$this->last_name = $last_name;
		return $this;
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setMobileNumber($mobile_no)
	{
		$this->mobile_no = $mobile_no;
		return $this;
	}

	public function getMobileNumber()
	{
		return $this->mobile_no;
	}

	public function setLandlineNumber($landline_no)
	{
		$this->landline_no = $landline_no;
		return $this;
	}

	public function getLandlineNumber()
	{
		return $this->landline_no;
	}

	public function setAbout($about)
	{
		$this->about = $about;
		return $this;
	}

	public function getAbout()
	{
		return $this->about;
	}

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

	public function getFriends()
	{
		return $this->friends;
	}

	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getFullName()
	{
		return $this->first_name." ".$this->last_name;
	}

	public function setInterests($interests)
	{
		$this->interests = $interests;
		return $this;
	}

	public function getInterests()
	{
		return $this->interests;
	}

	public function getPosts()
	{
		return $this->post;
	}

    public function getPostRead()
    {
        return $this->post_read;
    }

    public function getPostLiked()
    {
        return $this->post_liked;
    }

    public function getPostCommented()
    {
        return $this->post_commented;
    }

	public function getCommunityFollowed()
	{
		return $this->community;
	}

	public function getCredit()
	{
		return $this->credit;
	}

	public function toData()
	{
		$data = new stdClass;

		$this->dataHasGeneratedID($data);
		$data->first_name = $this->first_name;
		$data->last_name = $this->last_name;
		$data->email = $this->email;
		$data->mobile_no = $this->mobile_no;
		$data->landline_no = $this->landline_no;
		$data->about = $this->about;
        $data->username = $this->username;
		$this->dataHasEnabled($data);
		$this->dataTrackCreate($data);

		return $data;
	}
}