<?php

namespace Core\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\GroupInterface;

use stdClass;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    protected $account;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array();
        $this->groups = new ArrayCollection();
        $this->acl_cache = array();
        $this->flag_emailnotify = true;     
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
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
    
    public function toData()
    {
        $data = new stdClass();
        $data->id = $this->id;
        $data->username = $this->username;
        $data->email = $this->email;
        $data->name = $this->name;

        return $data;
    }
}
