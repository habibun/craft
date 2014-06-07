<?php

namespace Acme\PurchaseBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Purchase
{
    /*
     * @var int
     * */
    protected $id;

    /*
    * @var datetime
    * */
    protected $purchaseDate;

    /*
     * @var int
     * */
    protected $location;

    /*
     * @var int
     * */
    protected $supplier;


    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    /**
     * @param mixed $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return mixed
     */
    public function getSupplier()
    {
        return $this->supplier;
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
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }
} 