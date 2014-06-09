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
    protected $company;

    /*
    * @var int
    * */
    protected $depot;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
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
} 