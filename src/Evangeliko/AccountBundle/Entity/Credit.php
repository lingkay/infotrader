<?php

namespace Evangeliko\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasName;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_account_credit")
 */
class Credit
{
	use TrackCreate;
	use HasGeneratedID;

	/**
	 * @ORM\OneToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="credit")
	 * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
	 */
	protected $account;

	/** @ORM\Column(type="decimal", precision=10, scale=2, nullable=true) */
	protected $amount;

	function __construct()
	{
		$this->initTrackCreate();
		$this->amount = 0.00;
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

	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function toData()
	{
		$data = new stdClass();

		$this->dataHasGeneratedID($data);
		$this->dataTrackCreate($data);

		$data->account = $this->account->toData();
		$data->amount = $this->amount;

		return $data;
	}
}