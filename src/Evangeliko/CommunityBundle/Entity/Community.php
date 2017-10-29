<?php

namespace Evangeliko\CommunityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\TemplateBundle\Template\Entity\TrackCreate;
use Core\TemplateBundle\Template\Entity\HasGeneratedID;
use Core\TemplateBundle\Template\Entity\HasEnabled;
use Core\TemplateBundle\Template\Entity\HasName; 

use stdClass;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="evangeliko_community")
 */

class Community
{
	use TrackCreate;
	use HasGeneratedID;
	use HasEnabled;
	use HasName;

	/** @ORM\Column(type="string", length=50) */
	protected $slug;

	/** @ORM\Column(type="string", length=20) */
	protected $type;

	/** @ORM\Column(type="string", length=255) */
	protected $description;

	/**
	 * @ORM\OneToMany(targetEntity="\Evangeliko\CommunityBundle\Entity\CommunityFollowers", mappedBy="community")
	 */
	protected $followers;

	/**
	 * @ORM\OneToMany(targetEntity="\Evangeliko\PostBundle\Entity\Post", mappedBy="community")
	 */
	protected $post;

	/** @ORM\OneToMany(targetEntity="\Evangeliko\CommunityBundle\Entity\CommunityInterest", mappedBy="community") */
	protected $interest;

	/** @ORM\Column(type="json_array") */
	protected $interests;

	function __construct()
	{
		$this->initTrackCreate();
		$this->initHasEnabled();
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getFollowers()
	{
		return $this->followers;
	}

	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getPost()
	{
		return $this->post;
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

	public function toData()
	{
		$data = new stdClass;

		$this->dataHasGeneratedID($data);
		$this->dataHasName($data);

		$data->slug = $this->slug;
		$data->type = $this->type;
		// $data->followers = $this->followers->toData();

		$this->dataHasEnabled($data);
		$this->dataTrackCreate($data);

		return $data;
	}
}