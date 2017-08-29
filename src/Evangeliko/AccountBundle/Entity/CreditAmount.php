<?php

namespace Evangeliko\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasPrice;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_credit_amount")
 */
class CreditAmount
{
	use TrackCreate;
	use HasGeneratedID;
	use HasPrice;

	function __construct()
	{
		$this->initTrackCreate();
		$this->initHasPrice();
	}

	public function toData()
	{
		$data = new stdClass();

		$this->dataHasGeneratedID($data);
		$this->dataHasPrice($data);
		$this->dataTrackCreate($data);

		return $data;
	}
}