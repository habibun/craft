<?php

namespace Xshare\ProductBundle\Repository;

use Doctrine\ORM\EntityRepository;
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

        //search within the product name
        $dql = 'SELECT p.product_id id, p.name, p.description FROM XshareProductBundle:Product p
                WHERE (p.name LIKE :search_word
                OR p.description LIKE :search_word)
                AND p.enable = 1';

        $query = $this->_em->createQuery($dql)
                    ->setParameter('search_word', '%' . $search . '%');

        $result['products'] = $query->getArrayResult();

        //search within the categories
        $dql = 'SELECT c.name, c.category_id id FROM XshareProductBundle:Category c
                WHERE c.name LIKE :search_word';

        $query = $this->_em->createQuery($dql)
                    ->setParameter('search_word', '%' . $search . '%');

        $result['categories'] = $query->getArrayResult();

        //search within users
        $dql = 'SELECT u.username, u.firstname, u.lastname, u.user_id id FROM XshareUserBundle:User u
                WHERE u.username LIKE :search_word';

        $query = $this->_em->createQuery($dql)
                    ->setParameter('search_word', '%' . $search . '%');

        $result['users'] = $query->getArrayResult();

        return $result;
    }
    /**
     * general search implementation
     *
     * @author Iuli Dercaci
     * @param string $search
     * @return array
     */
    public function getSuggestSearchResults($search) {

        $result = array();

        //search within the product name
        $dql = 'SELECT p.name FROM XshareProductBundle:Product p
                WHERE (p.name LIKE :search_word
                OR p.description LIKE :search_word)
                AND p.enable = 1';

        $query = $this->_em->createQuery($dql)
                    ->setParameter('search_word', '%' . $search . '%');

        foreach ($query->getArrayResult() as $value) {
            $result[] = $value['name'];
        }

        //search within the categories
        $dql = 'SELECT c.name FROM XshareProductBundle:Category c
                WHERE c.name LIKE :search_word';

        $query = $this->_em->createQuery($dql)
                    ->setParameter('search_word', '%' . $search . '%');

        foreach ($query->getArrayResult() as $value) {
            $result[] = $value['name'];
        }

        //search within users
        $dql = 'SELECT u.username FROM XshareUserBundle:User u
                WHERE u.username LIKE :search_word';

        $query = $this->_em->createQuery($dql)
                    ->setParameter('search_word', '%' . $search . '%');

        foreach ($query->getArrayResult() as $value) {
            $result[] = $value['name'];
        }

        return $result;
    }

    /**
     * saving the search word
     *
     * @param string $searchWord
     * @return boolean
     */
    public function saveSerchRequest($searchWord) {

            $statistics = new \Xshare\ProductBundle\Entity\SearchStatistics();
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

    public function test(){
        return 'test';
    }

}