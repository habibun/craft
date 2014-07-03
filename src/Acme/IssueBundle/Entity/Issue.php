<?php

namespace Acme\IssueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Issue
 */
class Issue
{

    private $id;
    private $issueDate;
    private $company;
    private $depot;
    protected $status;

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
     * Set issueDate
     *
     * @param \DateTime $issueDate
     * @return Issue
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Get issueDate
     *
     * @return \DateTime 
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Issue
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set depot
     *
     * @param string $depot
     * @return Issue
     */
    public function setDepot($depot)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return string 
     */
    public function getDepot()
    {
        return $this->depot;
    }
    /**
     * Set status
     *
     * @param string $status
     * @return Status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}