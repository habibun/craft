<?php

namespace Acme\PurchaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Purchase
{
    protected $id;
    protected $purchaseDate;
    protected $company;
    protected $depot;
    protected $status;
    protected $lines;
    protected $createdAt;
    protected $createdBy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lines = new ArrayCollection();
        $this->SetCreatedAt(new \DateTime());
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

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * @return mixed
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $depot
     */
    public function setDepot($depot)
    {
        $this->depot = $depot;
    }

    /**
     * @return mixed
     */
    public function getDepot()
    {
        return $this->depot;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $purchaseDate
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;
    }

    /**
     * @return mixed
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }


} 