<?php

namespace Acme\DashBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\DashBundle\Entity\SearchStatistics
 * @ORM\Table(name="search_statistics")
 * @ORM\Entity(repositoryClass="Acme\DashBundle\Repository\SearchStatisticsRepository")
 */
class SearchStatistics
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $search_id;

    /**
     * @ORM\Column(type="string")
     */
    private $keyword_search;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_search;

    public function __construct()
    {
        $this->setDateSearch(new \DateTime);
    }

    /**
     * Get search_id
     * @return integer
     */
    public function getSearchId()
    {
        return $this->search_id;
    }

    /**
     * Set keyword_search
     * @param string $keywordSearch
     */
    public function setKeywordSearch($keywordSearch)
    {
        $this->keyword_search = $keywordSearch;
    }

    /**
     * Get keyword_search
     * @return string
     */
    public function getKeywordSearch()
    {
        return $this->keyword_search;
    }

    /**
     * Set date_search
     * @param datetime $dateSearch
     */
    public function setDateSearch($dateSearch)
    {
        $this->date_search = $dateSearch;
    }

    /**
     * Get date_search
     * @return datetime
     */
    public function getDateSearch()
    {
        return $this->date_search;
    }
}