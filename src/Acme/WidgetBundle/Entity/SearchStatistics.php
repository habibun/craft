<?php

namespace Acme\WidgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SearchStatistics
 */
class SearchStatistics
{
    /**
     * @var integer
     */
    private $searchId;

    /**
     * @var string
     */
    private $keywordSearch;

    /**
     * @var \DateTime
     */
    private $dateSearch;


    public function __construct()
    {
        $this->setDateSearch(new \DateTime);
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
     * Set searchId
     *
     * @param integer $searchId
     * @return SearchStatistics
     */
    public function setSearchId($searchId)
    {
        $this->searchId = $searchId;

        return $this;
    }

    /**
     * Get searchId
     *
     * @return integer 
     */
    public function getSearchId()
    {
        return $this->searchId;
    }

    /**
     * Set keywordSearch
     *
     * @param string $keywordSearch
     * @return SearchStatistics
     */
    public function setKeywordSearch($keywordSearch)
    {
        $this->keywordSearch = $keywordSearch;

        return $this;
    }

    /**
     * Get keywordSearch
     *
     * @return string 
     */
    public function getKeywordSearch()
    {
        return $this->keywordSearch;
    }

    /**
     * Set dateSearch
     *
     * @param \DateTime $dateSearch
     * @return SearchStatistics
     */
    public function setDateSearch($dateSearch)
    {
        $this->dateSearch = $dateSearch;

        return $this;
    }

    /**
     * Get dateSearch
     *
     * @return \DateTime 
     */
    public function getDateSearch()
    {
        return $this->dateSearch;
    }
}
