<?php
/**
 * Created by Habibun Noby.
 * File Name: ReportController.php
 * Date: 7/8/14
 * Time: 8:40 AM
 */

namespace Acme\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller {

    public function purchaseAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data = $this->getRequest()->request->all();
        if(!empty($data))
        {
            $data = $data['report'];
            if(!empty($data['fromDate']) && !empty($data['toDate']))
            {
                $reportData = $this->_generatePurchaseReport($data);
                $html = $this->renderView('AcmeReportBundle:Report:pdfPurchase.html.twig',
                    array(
                        'reportData' => $reportData,
                        'company' => $this->getUser()->getCompany(),
                        'location' => $em->getRepository('AcmeReportBundle:Location')->find($data['location']),
                        'params' => $data
                    )
                );

                $fileName = 'purchase_report_'.time().'.pdf';
                return new Response(
                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                            'page-size' => 'A4',
                        )),
                    200,
                    array(
                        'Content-Type'          => 'application/pdf',
                        'Content-Disposition'   => 'attachment; filename="'.$fileName.'"'
                    )
                );
            }
        }
        return $this->render('AcmeReportBundle:Report:purchase.html.twig');
    }

    private function _generatePurchaseReport($params)
    {
        if(empty($params['fromDate']) || empty($params['toDate']))
            return false;

        $fromDate = new \DateTime($params['fromDate']);
        $toDate = new \DateTime($params['toDate']);

        $em = $this->getDoctrine()->getManager();
        $dql = "
            select p from RaPurchaseBundle:Purchase p
            where p.status = 3
            and p.purchaseDate between :fromDate and :toDate
            and p.location = :location
        ";

        if($params['supplier'] != -1)
            $dql .= " and p.supplier = :supplier";

        $dql .= " order by p.supplier, p.purchaseDate asc";

        $query = $em->createQuery($dql)
            ->setParameter('fromDate', $fromDate->format('Y-m-d H:i:s'))
            ->setParameter('toDate', $toDate->format('Y-m-d H:i:s'))
            ->setParameter('location', $params['location']);

        if($params['supplier'] != -1)
            $query->setParameter('supplier', $params['supplier']);

        $results = $query->getResult();
        $reportData = array();
        if($results)
        {
            foreach($results as $row)
            {
                $reportData[$row->getSupplier()->getId()][] = $row;
            }
        }
        return $reportData;
    }

} 