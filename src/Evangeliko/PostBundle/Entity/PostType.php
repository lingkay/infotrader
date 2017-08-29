<?php

namespace Evangeliko\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasName;

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_post_type")
 */
class PostType
{
	use TrackCreate;
	use HasGeneratedID;
	use HasName;

	function __construct()
	{
		$this->initTrackCreate();
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