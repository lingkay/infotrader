<?php

namespace Core\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\GroupInterface;

use JMS\Serializer\Annotation as JMS;

use stdClass;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_user", indexes={@ORM\Index(name="hashid_idx", columns={"hashid"})})
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Groups({"Default"})
     */
    protected $id;

    /** 
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true) 
     *
     * @JMS\Expose
     * @JMS\Groups({"Default", "widget"}) 
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="\Evangeliko\AccountBundle\Entity\Account", inversedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    protected $account;

    /**
     * @ORM\OneToOne(targetEntity="\Core\ApiBundle\Entity\Client")
    */
    private $oauthClient;

    /**
     * @ORM\Column(name="hashid", type="string", length=255, nullable=true)
     */
    private $hashid;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array();
        $this->groups = new ArrayCollection();
        $this->acl_cache = array();
        $this->flag_emailnotify = true;     
    }

    public function setHashid($hashid)
    {
      $this->hashid = $hashid;
        
      return $this;
    }
        
    public function getHashid()
    {
      return $this->hashid;
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

    public function setOAuthClient($oauthClient = null)
    {
      $this->oauthClient = $oauthClient;
        
      return $this;
    }
    public function getOAuthClient()
    {
      return $this->oauthClient;
    }

}

