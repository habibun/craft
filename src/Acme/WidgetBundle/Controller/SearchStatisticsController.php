<?php
/**
 * Created by PhpStorm.
 * User: jony
 * Date: 3/11/2014
 * Time: 2:39 PM
 */
namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SearchStatisticsController extends Controller
{

    public function searchAction($searchWord)
    {
        $result = array();
        $search = trim($searchWord);
        if (strlen($search)) {
            $repository = $this->getDoctrine()->getManager()->getRepository('AcmeWidgetBundle:SearchStatistics');
            $result = $repository->getGeneralSearchResults(strtolower($search));
            //save statistics
            $repository->saveSerchRequest($search);
        }
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $result,
            $this->get('request')->query->get('page', 1)
            /*page number*/,
            10/*limit per page*/
        );

        return $this->render(
            'AcmeWidgetBundle:SearchStatistics:searchResult.html.twig',
            array('result' => $result, 'search' => $search,)
        );
    }

    public function autocompleteAction(Request $request)
    {
        $search = strtolower(trim($request->get('term')));
        $result = array();
        if (strlen($search) > 2) {
            $result = $this->getDoctrine()->getManager()->getRepository(
                'AcmeWidgetBundle:SearchStatistics'
            )->getSuggestSearchResults($search);
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function topSearchListAction()
    {
        $words = $this->getDoctrine()->getManager()->getRepository(
            "AcmeWidgetBundle:SearchStatistics"
        )->getTopSearchedKeyWords(6);

        return $this->render(
            'AcmeWidgetBundle:SearchStatistics:topSearchList.html.twig',
            array(
                'words' => $words,
            )
        );
    }
}
