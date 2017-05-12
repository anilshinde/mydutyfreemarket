<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_opened", type="datetime")
     */
    private $dateOpened;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_validated", type="datetime", nullable=true)
     */
    private $dateValidated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cancelled", type="datetime", nullable=true)
     */
    private $dateCancelled;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string", length=255)
     */
    private $customerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_phone", type="string", length=255)
     */
    private $customerPhone;

    /**
     * @var int
     *
     * @ORM\Column(name="payment", type="integer")
     */
    private $payment;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_vat", type="float")
     */
    private $amountVat;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_fees", type="float")
     */
    private $amountFees;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_firstname", type="string", length=100)
     */
    private $customerFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_lastname", type="string", length=100)
     */
    private $customerLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_address", type="string", length=255)
     */
    private $customerAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_city", type="string", length=100)
     */
    private $customerCity;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_zipcode", type="string", length=50)
     */
    private $customerZipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_state", type="string", length=100)
     */
    private $customerState;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateOpened
     *
     * @param \DateTime $dateOpened
     *
     * @return Transaction
     */
    public function setDateOpened($dateOpened)
    {
        $this->dateOpened = $dateOpened;

        return $this;
    }

    /**
     * Get dateOpened
     *
     * @return \DateTime
     */
    public function getDateOpened()
    {
        return $this->dateOpened;
    }

    /**
     * Set dateValidated
     *
     * @param \DateTime $dateValidated
     *
     * @return Transaction
     */
    public function setDateValidated($dateValidated)
    {
        $this->dateValidated = $dateValidated;

        return $this;
    }

    /**
     * Get dateValidated
     *
     * @return \DateTime
     */
    public function getDateValidated()
    {
        return $this->dateValidated;
    }

    /**
     * Set dateCancelled
     *
     * @param \DateTime $dateCancelled
     *
     * @return Transaction
     */
    public function setDateCancelled($dateCancelled)
    {
        $this->dateCancelled = $dateCancelled;

        return $this;
    }

    /**
     * Get dateCancelled
     *
     * @return \DateTime
     */
    public function getDateCancelled()
    {
        return $this->dateCancelled;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return Transaction
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerPhone
     *
     * @param string $customerPhone
     *
     * @return Transaction
     */
    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;

        return $this;
    }

    /**
     * Get customerPhone
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * Set payment
     *
     * @param integer $payment
     *
     * @return Transaction
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return int
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set amountVat
     *
     * @param float $amountVat
     *
     * @return Transaction
     */
    public function setAmountVat($amountVat)
    {
        $this->amountVat = $amountVat;

        return $this;
    }

    /**
     * Get amountVat
     *
     * @return float
     */
    public function getAmountVat()
    {
        return $this->amountVat;
    }

    /**
     * Set amountFees
     *
     * @param string $amountFees
     *
     * @return Transaction
     */
    public function setAmountFees($amountFees)
    {
        $this->amountFees = $amountFees;

        return $this;
    }

    /**
     * Get amountFees
     *
     * @return string
     */
    public function getAmountFees()
    {
        return $this->amountFees;
    }

    /**
     * Set customerFirstname
     *
     * @param string $customerFirstname
     *
     * @return Transaction
     */
    public function setCustomerFirstname($customerFirstname)
    {
        $this->customerFirstname = $customerFirstname;

        return $this;
    }

    /**
     * Get customerFirstname
     *
     * @return string
     */
    public function getCustomerFirstname()
    {
        return $this->customerFirstname;
    }

    /**
     * Set customerLastname
     *
     * @param string $customerLastname
     *
     * @return Transaction
     */
    public function setCustomerLastname($customerLastname)
    {
        $this->customerLastname = $customerLastname;

        return $this;
    }

    /**
     * Get customerLastname
     *
     * @return string
     */
    public function getCustomerLastname()
    {
        return $this->customerLastname;
    }

    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     *
     * @return Transaction
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    /**
     * Get customerAddress
     *
     * @return string
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set customerCity
     *
     * @param string $customerCity
     *
     * @return Transaction
     */
    public function setCustomerCity($customerCity)
    {
        $this->customerCity = $customerCity;

        return $this;
    }

    /**
     * Get customerCity
     *
     * @return string
     */
    public function getCustomerCity()
    {
        return $this->customerCity;
    }

    /**
     * Set customerZipcode
     *
     * @param string $customerZipcode
     *
     * @return Transaction
     */
    public function setCustomerZipcode($customerZipcode)
    {
        $this->customerZipcode = $customerZipcode;

        return $this;
    }

    /**
     * Get customerZipcode
     *
     * @return string
     */
    public function getCustomerZipcode()
    {
        return $this->customerZipcode;
    }

    /**
     * Set customerState
     *
     * @param string $customerState
     *
     * @return Transaction
     */
    public function setCustomerState($customerState)
    {
        $this->customerState = $customerState;

        return $this;
    }

    /**
     * Get customerState
     *
     * @return string
     */
    public function getCustomerState()
    {
        return $this->customerState;
    }
}

