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

        //search within the purchaseLine
        $dql = 'SELECT  p.price, p.quantity,p.id id FROM AcmePurchaseBundle:PurchaseLine p
                WHERE p.id LIKE :search_word';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['PurchaseLines'] = $query->getArrayResult();

        //search within the issueLine
        $dql = 'SELECT i.issueTo, i.referenceNumber, i.id id FROM AcmeIssueBundle:IssueLine i
                WHERE i.issueTo LIKE :search_word';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['issueLines'] = $query->getArrayResult();

        //search within users
        $dql = 'SELECT u.username, u.email, u.id id FROM AcmeUserBundle:User u
                WHERE u.username LIKE :search_word';

        $query = $this->_em->createQuery($dql)
            ->setParameter('search_word', '%' . $search . '%');

        $result['users'] = $query->getArrayResult();

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