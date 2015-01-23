<?php

namespace Acme\InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceLine
 */
class InvoiceLine
{

    private $id;

    private $description;

    private $unitPrice;

    private $quantity;

    private $invoice;


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
     * Set description
     *
     * @param string $description
     * @return InvoiceLine
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set unitPrice
     *
     * @param integer $unitPrice
     * @return InvoiceLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return integer 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getInvoice()
    {
        return $this->invoice;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
