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
 * @ORM\Table(name="evangeliko_account_credit_history")
 */
class CreditHistory
{
	use TrackCreate;
	use HasGeneratedID;

	/**
	 * @ORM\ManyToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Credit", inversedBy="history")
	 * @ORM\JoinColumn(name="credit_id", referencedColumnName="id")
	 */
	protected $credit;

	/** @ORM\Column(type="decimal", precision=10, scale=2, nullable=true) */
	protected $amount;

	function __construct()
	{
		$this->initTrackCreate();
		$this->amount = 0.00;
	}

	public function setCredit($credit)
	{
		$this->credit = $credit;
		return $this;
	}

	public function getCredit()
	{
		return $this->credit;
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
		$this->dataHasName($data);
		$this->dataTrackCreate($data);

		return $data;
	}
}