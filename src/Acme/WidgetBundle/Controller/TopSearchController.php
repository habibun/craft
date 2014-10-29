<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TopSearchController extends Controller
{
	public function topSearchListAction($limit = 6)
    {
        //getting top 6 searched keywords from DB
        $query_builder = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb = $query_builder
            ->select('s.keyword_search, count(s.search_id) as keywords')
            ->from('AcmeDashBundle:SearchStatistics', 's')
            ->groupBy('s.keyword_search')
            ->orderBy('keywords', 'desc')
            ->setMaxResults($limit);

        $query = $qb->getQuery();
        $words = $query->getResult();

        //responce
        return $this->render(
            'AcmeWidgetBundle:TopSearch:topSearchList.html.twig',
            array(
                'words' => $words,
            )
        );
    }

    
}