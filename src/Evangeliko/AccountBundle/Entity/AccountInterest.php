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
 * @ORM\Table(name="evangeliko_account_interest")
 */
class AccountInterest
{
	use TrackCreate;
	use HasGeneratedID;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="interest")
	 * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
	 */
	protected $account;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Interest", inversedBy="account")
	 * @ORM\JoinColumn(name="interest_id", referencedColumnName="id")
	 */
	protected $interest;

	function __construct()
	{
		$this->initTrackCreate();
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