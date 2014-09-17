<?php

namespace Acme\DashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SearchController extends Controller
{
    /**
     * render search results
     * @param $searchWord
     * @return Response
     * @Route("/search/{searchWord}", name="general_search", defaults={"searchWord"=""})
     * @Method({"GET"})
     */

    public function searchAction($searchWord)
    {
        $result = array();

        $search = trim($searchWord);

        if (strlen($search)) {

            $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('AcmeDashBundle:SearchStatistics');

            $result = $repository->getGeneralSearchResults(strtolower($search));

            //save statistics
            $repository->saveSerchRequest($search);
        }

        return $this->render(
            'AcmeDashBundle:Search:searchResult.html.twig',
            array(
                'result' => $result,
            )
        );
    }

    /**
     * list of 6 top searched words
     * @return Response
     * @Method({"GET"})
     */
    public function topSearchListAction()
    {
        //getting top 6 searched keywords from DB
        $words = $this->getDoctrine()
            ->getManager()
            ->getRepository("AcmeDashBundle:SearchStatistics")
            ->getTopSearchedKeyWords(6);

        //responce
        return $this->render(
            'AcmeDashBundle:Search:topSearchList.html.twig',
            array(
                'words' => $words,
            )
        );
    }
}