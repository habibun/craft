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
     *
     * @author Iuli Dercaci
     * @param string $search
     * @return array
     */
    public function getGeneralSearchResults($search) {

        $result = array();



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
     *
     * @param string $searchWord
     * @return boolean
     */
    public function saveSerchRequest($searchWord) {

            $statistics = new SearchStatistics();
            $statistics->setKeywordSearch($searchWord);
            $this->_em->persist($statistics);
            $this->_em->flush();

            return true;
    }

    /**
     * @author cchiu
     * get top 6 searched keywords
     *
     * @param int $limit
     * @return \MakerLabs\PagerBundle\Adapter\ArrayAdapter
     */
    public function getTopSearchedKeyWords($limit = null)
    {
        $qb = $this->_em->createQueryBuilder()
                ->select('s.keyword_search, count(s.search_id) as keywords')
                ->from('XshareProductBundle:SearchStatistics', 's')
                ->groupBy('s.keyword_search')
                ->orderBy('keywords','desc')
                ->setMaxResults($limit);

        $res = $qb->getQuery()->getArrayResult();

        return new ArrayAdapter($res);
    }

}