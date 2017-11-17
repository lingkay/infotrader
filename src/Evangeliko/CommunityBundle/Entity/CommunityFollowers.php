<?php

namespace Evangeliko\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasEnabled;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_community_followers")
 */

class CommunityFollowers
{
	const STATUS_PENDING = "Pending";
	const STATUS_FOLLOW = "Followed";
	const STATUS_UNFOLLOW = "Unfollowed";

	use TrackCreate;
	use HasGeneratedID;
	use HasEnabled;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\CommunityBundle\Entity\Community", inversedBy="followers")
	 * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
	 */
	protected $community;

    /**
     * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="followed_community")
     * @ORM\JoinColumn(name="follower_id", referencedColumnName="id")
     */
    protected $follower;

	/** @ORM\Column(type="string", length=15) */
	protected $status;

	function __construct()
	{
		$this->initTrackCreate();
		$this->initHasEnabled();
		$this->status = self::STATUS_PENDING;
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

	public function setFollower($follower)
	{
		$this->follower = $follower;
		return $this;
	}

	public function getFollower()
	{
		return $this->follower;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function toData()
	{
		$data = new stdClass;

		$this->dataHasGeneratedID($data);
		$data->community = $this->community->getID();
		$data->follower = $this->follower->toData();
		$data->status = $this->status;
		$this->dataHasEnabled($data);
		$this->dataTrackCreate($data);

		return $data;
	}
}