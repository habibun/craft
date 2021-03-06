<?php

namespace Acme\WidgetBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Acme\WidgetBundle\Entity\SearchStatistics;

/**
 * SearchStatisticsRepository
 */
class SearchStatisticsRepository extends EntityRepository
{
    public function getGeneralSearchResults($search)
    {
        $result = array();

        //search within the purchaseLine for price information
        $dql = 'SELECT p.price, p.manufacturer, p.quantity, p.id id, pr.name, pu.purchaseDate
                FROM AcmePurchaseBundle:PurchaseLine p
                JOIN p.product pr
                JOIN p.purchase pu
                WHERE pr.name LIKE :search_word
                ORDER BY pu.purchaseDate DESC';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['PurchaseLines'] = $query->getArrayResult();

        //search within the issueLine for issue information
        $dql = 'SELECT i.issueTo, i.quantity, i.id id, iss.issueDate, pro.name
                FROM AcmeIssueBundle:IssueLine i
                JOIN i.issue iss
                JOIN i.product pro
                WHERE i.issueTo LIKE :search_word
                ORDER BY iss.issueDate DESC';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['issueLines'] = $query->getArrayResult();

        return $result;
    }

    //saving the search word
    public function saveSerchRequest($searchWord)
    {
        $statistics = new SearchStatistics();
        $statistics->setKeywordSearch($searchWord);
        $this->_em->persist($statistics);
        $this->_em->flush();

        return true;
    }

    //get suggested results
    public function getSuggestSearchResults($search)
    {

        $result = array();

        //search within the product for product name
        $dql = 'SELECT p.name FROM AcmeSetupBundle:Product p
                WHERE p.name LIKE :search_word';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        foreach ($query->getArrayResult() as $value) {
            $result[] = $value['name'];
        }

        //search within the issueLine for issued person
        $dql = 'SELECT i.issueTo FROM AcmeIssueBundle:IssueLine i
                WHERE i.issueTo LIKE :search_word';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        foreach ($query->getArrayResult() as $value) {
            $result[] = $value['issueTo'];
        }

        return $result;
    }

    //get top 6 searched keywords
    public function getTopSearchedKeyWords($limit = null)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('s.keywordSearch, count(s.searchId) as keywords')
            ->from('AcmeWidgetBundle:SearchStatistics', 's')
            ->groupBy('s.keywordSearch')
            ->orderBy('keywords', 'desc')
            ->setMaxResults($limit);

        try {
            $result = $qb->getQuery()->getArrayResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $result = null;
        }

        return $result;
    }
}
