<?php
/**
 * Created by PhpStorm.
 * User: jony
 * Date: 3/11/2014
 * Time: 2:39 PM
 */

namespace Acme\WidgetBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchStatisticsController extends Controller{

    public function searchAction($searchWord)
    {
        $result = array();

        $search = trim($searchWord);

        if (strlen($search)) {

            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('AcmeWidgetBundle:SearchStatistics');

            $result = $repository->getGeneralSearchResults(strtolower($search));

            //save statistics
            $repository->saveSerchRequest($search);
        }
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $result,
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        /*limit per page*/
        );

        return $this->render(
            'AcmeWidgetBundle:SearchStatistics:searchResult.html.twig',
            array(
                'result' => $result,
                'search' => $search,
            )
        );
    }

} 