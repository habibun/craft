<?php

namespace Acme\DashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/*use Xshare\GeneralBundle\Entity\Contact;
use Xshare\GeneralBundle\Form\ContactType;*/

class SearchController extends Controller {

    /**
     * render the Contacts page
     *
     * @author Iuli Dercaci
     * @return Response
     * @Route("/search-autocomplete",
     * name="search_autocomplete",
     * defaults={"_locale"="ro"})
     * @Method({"GET"})
     */
    public function autocompleteAction(Request $request){

        $search = strtolower( trim($request->get('term') ));
        
        $result = array();

        if (strlen($search) > 2) {

            $result = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('XshareProductBundle:SearchStatistics')
                    ->getSuggestSearchResults($search);
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * render the Contacts page
     *
     * @author Iuli Dercaci
     * @return Response
     * @Route("/search/{searchWord}", name="general_search", defaults={"searchWord"=""})
     * @Method({"GET"})
     */

    public function searchAction($searchWord){

/*        //breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('Home'), $this->get("router")->generate("xshare_general_default_index"));
        $breadcrumbs->addItem($this->get('translator')->trans('Search result'), null);*/

        $result = array();

        $search = trim($searchWord);

        if (strlen($search)) {

            $repository = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('XshareProductBundle:SearchStatistics');

            $result = $repository->getGeneralSearchResults(strtolower($search));

            //save statistics
            $repository->saveSerchRequest($search);
        }

        return $this->render('AcmeDashBundle:Search:searchResult.html.twig', array(
            'result'   => $result,
        ));
    }

    /**
     * list of 6 top searched words
     *
     * @author cchiu
     * @return Response
     *
     * @Method({"GET"})
     */
    public function topSearchListAction() {

        //getting top 6 searched keywords from DB
        $words = $this->getDoctrine()
                      ->getEntityManager()
                      ->getRepository("XshareProductBundle:SearchStatistics")
                      ->getTopSearchedKeyWords(6);

        //responce

        return $this->render('XshareProductBundle:Search:topSearchList.html.twig', array(
            'words' => $words,
        ));
    }

}