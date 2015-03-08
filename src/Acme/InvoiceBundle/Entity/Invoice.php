<?php

namespace Acme\InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Invoice
 */
class Invoice
{

    private $id;

    private $name;

    private $address;

    private $invoiceDate;

    private $invoiceStatus;

    private $invoiceLines;

    protected $createdAt;
    
    protected $createdBy;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setInvoiceStatus($invoiceStatus)
    {
        $this->invoiceStatus = $invoiceStatus;

        return $this;
    }

    public function getInvoiceStatus()
    {
        return $this->invoiceStatus;
    }


    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Invoice
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Invoice
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function setInvoiceLines($invoiceLines)
    {
        $this->invoiceLines = $invoiceLines;

        return $this;
    }

    public function getInvoiceLines()
    {
        return $this->invoiceLines;
    }
}