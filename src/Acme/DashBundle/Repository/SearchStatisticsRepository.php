<?php

namespace Acme\DashBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Acme\DashBundle\Entity\SearchStatistics;
use MakerLabs\PagerBundle\Adapter\ArrayAdapter;

/**
 * SearchStatisticsRepository
 */
class SearchStatisticsRepository extends EntityRepository
{

    /**
     * general search implementation
     * @param string $search
     * @return array
     */
    public function getGeneralSearchResults($search)
    {

        $result = array();

        //search within the purchaseLine for price information
        $dql = 'SELECT p.price, p.manufacturer, p.quantity, p.id id, pr.name, pu.purchaseDate
                FROM AcmePurchaseBundle:PurchaseLine p
                INNER JOIN p.product pr
                INNER JOIN p.purchase pu
                WHERE pr.name LIKE :search_word
                ORDER BY pu.purchaseDate DESC';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['PurchaseLines'] = $query->getArrayResult();

        //search within the issueLine for issue information
        $dql = 'SELECT i.issueTo, i.quantity, i.id id, iss.issueDate, pro.name
                FROM AcmeIssueBundle:IssueLine i
                INNER JOIN i.issue iss
                INNER JOIN i.product pro
                WHERE i.issueTo LIKE :search_word
                ORDER BY iss.issueDate DESC';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['issueLines'] = $query->getArrayResult();

        return $result;
    }


    /**
     * saving the search word
     * @param string $searchWord
     * @return boolean
     */
    public function saveSerchRequest($searchWord)
    {

        $statistics = new SearchStatistics();
        $statistics->setKeywordSearch($searchWord);
        $this->_em->persist($statistics);
        $this->_em->flush();

        return true;
    }

    /**
     * get top 6 searched keywords
     * @param int $limit
     * @return \MakerLabs\PagerBundle\Adapter\ArrayAdapter
     */
    public function getTopSearchedKeyWords($limit = null)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('s.keyword_search, count(s.search_id) as keywords')
            ->from('AcmeDashBundle:SearchStatistics', 's')
            ->groupBy('s.keyword_search')
            ->orderBy('keywords', 'desc')
            ->setMaxResults($limit);

        $res = $qb->getQuery()->getArrayResult();

        return new ArrayAdapter($res);
    }

}