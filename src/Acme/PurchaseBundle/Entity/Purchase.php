<?php

namespace Acme\PurchaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Purchase
{
    protected $id;
    protected $purchaseDate;
    protected $supplier;
    protected $location;
    protected $status;
    protected $lines;
    protected $createdAt;
    protected $createdBy;
    protected $updatedAt;
    protected $updatedBy;
    protected $finalizedBy;
    protected $finalizeDate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lines = new ArrayCollection();
        $this->SetCreatedAt(new \DateTime());
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
     * Set status
     *
     * @param integer $status
     * @return Purchase
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     * @return Purchase
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime 
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Purchase
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Purchase
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set finalizeDate
     *
     * @param \DateTime $finalizeDate
     * @return Purchase
     */
    public function setFinalizeDate($finalizeDate)
    {
        $this->finalizeDate = $finalizeDate;

        return $this;
    }

    /**
     * Get finalizeDate
     *
     * @return \DateTime 
     */
    public function getFinalizeDate()
    {
        return $this->finalizeDate;
    }

    /**
     * Add lines
     *
     * @param \Acme\PurchaseBundle\Entity\PurchaseLine $lines
     * @return Purchase
     */
    public function addLine(\Acme\PurchaseBundle\Entity\PurchaseLine $lines)
    {
        $this->lines[] = $lines;

        return $this;
    }

    /**
     * Remove lines
     *
     * @param \Acme\PurchaseBundle\Entity\PurchaseLine $lines
     */
    public function removeLine(\Acme\PurchaseBundle\Entity\PurchaseLine $lines)
    {
        $this->lines->removeElement($lines);
    }

    /**
     * Get lines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Set supplier
     *
     * @param \Acme\SetupBundle\Entity\Supplier $supplier
     * @return Purchase
     */
    public function setSupplier(\Acme\SetupBundle\Entity\Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \Acme\SetupBundle\Entity\Supplier 
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set location
     *
     * @param \Acme\SetupBundle\Entity\Location $location
     * @return Purchase
     */
    public function setLocation(\Acme\SetupBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Acme\SetupBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set createdBy
     *
     * @param \Acme\UserBundle\Entity\User $createdBy
     * @return Purchase
     */
    public function setCreatedBy(\Acme\UserBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \Acme\UserBundle\Entity\User $updatedBy
     * @return Purchase
     */
    public function setUpdatedBy(\Acme\UserBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set finalizedBy
     *
     * @param \Acme\UserBundle\Entity\User $finalizedBy
     * @return Purchase
     */
    public function setFinalizedBy(\Acme\UserBundle\Entity\User $finalizedBy = null)
    {
        $this->finalizedBy = $finalizedBy;

        return $this;
    }

    /**
     * Get finalizedBy
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getFinalizedBy()
    {
        return $this->finalizedBy;
    }
}
