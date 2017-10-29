<?php

namespace Evangeliko\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * @ORM\Table(name="evangeliko_orders")
 * @ORM\Entity
 */
class Order
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") */
    private $paymentInstruction;

    /** @ORM\Column(type="decimal", precision=10, scale=5) */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Evangeliko\AccountBundle\Entity\Credit")
     * @ORM\JoinColumn(name="credit_id", referencedColumnName="id")
     */
    protected $credit;

    /** @ORM\Column(type="integer") */
    private $redirect;

    public function __construct($amount,$credit,$redirect)
    {
        $this->amount = $amount;
        $this->credit = $credit;
        $this->redirect = $redirect;
    }

    public function setRedirectID($redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }

    public function getRedirectID()
    {
        return $this->redirect;
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

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }
}