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
 * @ORM\Table(name="evangeliko_friendship")
 */

class Friendship
{
	const STATUS_PENDING = "Pending";
	const STATUS_ACCEPT = "Accept";
	const STATUS_UNFRIEND = "Unfriend";

	use TrackCreate;
	use HasGeneratedID;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="friends")
	 * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
	 */
	protected $account;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="account")
	 * @ORM\JoinColumn(name="friend_id", referencedColumnName="id")
	 */
	protected $friend;

	/** @ORM\Column(type="string", length=20) */
	protected $status;

	function __construct()
	{
		$this->initTrackCreate();
		$this->initHasEnabled();
		$this->status = self::STATUS_PENDING;
	}

	public function setAccount($account)
	{
		$this->account = $account;
		return $this;
	}

	public function getAccount(){
		return $this->account;
	}

	public function setFriend($friend)
	{
		$this->friend = $friend;
		return $this;
	}

	public function getFriend()
	{
		return $this->friend;
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
}