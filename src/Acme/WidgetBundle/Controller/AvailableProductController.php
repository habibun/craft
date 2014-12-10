<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AvailableProductController extends Controller
{
    public function availableProductAction()
    {
        $ap = $this->_getAvailableProductResult();
        var_dump($ap);

        return $this->render('AcmeWidgetBundle:AvailableProduct:index.html.twig',array(
                'ap' => $ap
            ));
    }

    private function _getAvailableProductResult()
    {
        $query = $this->getEntityManager($this->em)
            ->createQueryBuilder('u')
            ->select(
                'u.ratingkey, u.origTitle, u.origTitleEp, u.episode, u.season, u.year, u.xml, count(u.title) as playCount'
            )
            ->from($this->class, 'u')
            ->groupBy('u.title')
            ->orderBy('playCount', 'desc')
            ->addOrderBy('u.ratingkey', 'desc')
            ->setMaxResults(10)
            ->getQuery();

        return $query->getResult();
    }

    private function testResult()
    {
        $q = Doctrine_Query::create()
            ->select('count(*)')
            ->from('mbScoreByGenre s')
            ->where('s.parent_genre_id = ?', $genre['parent_id'])
            ->having(
                "SUM(s.score) > (
    SELECT SUM(p.score)
    FROM mbScoreByGenre p
    WHERE p.parent_genre_id = {$genre['parent_id']}
      AND p.user_id = {$user_id})"
            )
            ->groupBy('s.user_id');

        $result = $q->execute(array(), Doctrine::HYDRATE_SCALAR);
        var_dump($result);
    }
}