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
 * @ORM\Table(name="evangeliko_community_interest")
 */
class CommunityInterest
{
	use TrackCreate;
	use HasGeneratedID;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\CommunityBundle\Entity\Community", inversedBy="interest")
	 * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
	 */
	protected $community;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Interest", inversedBy="account")
	 * @ORM\JoinColumn(name="interest_id", referencedColumnName="id")
	 */
	protected $interest;

	function __construct()
	{
		$this->initTrackCreate();
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

	public function setInterest($interest)
	{
		$this->interest = $interest;
	}

	public function getInterest()
	{
		return $this->interest;
	}

	public function toData()
	{
		$data = new stdClass();

		$this->dataHasGeneratedID($data);

		$data->account = $this->account->toData();
		$data->interest = $this->interest->toData();

		$this->dataTrackCreate($data);

		return $data;
	}

}