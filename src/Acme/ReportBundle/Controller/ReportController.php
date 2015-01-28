<?php
/**
 * Created by Habibun Noby.
 * File Name: ReportController.php
 * Date: 7/8/14
 * Time: 8:40 AM
 */

namespace Acme\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller {

	public function purchaseAction() {
		$em = $this->getDoctrine()->getManager();

		$data = $this->getRequest()->request->all();
		if (!empty($data)) {
			$data = $data['report'];
			if (!empty($data['fromDate']) && !empty($data['toDate'])) {
				$reportData = $this->_generatePurchaseReport($data);
				$html = $this->renderView(
					'AcmeReportBundle:Report:pdfPurchase.html.twig',
					array(
						'reportData' => $reportData,
						'params' => $data,
					)
				);

				$fileName = 'purchase_report_' . time() . '.pdf';

				return new Response(
					$this->get('knp_snappy.pdf')->getOutputFromHtml(
						$html,
						array(
							'page-size' => 'A4',
						)
					),
					200,
					array(
						'Content-Type' => 'application/pdf',
						'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
					)
				);
			}
		}

		return $this->render('AcmeReportBundle:Report:purchaseReport.html.twig');
	}

	private function _generatePurchaseReport($params) {
		if (empty($params['fromDate']) || empty($params['toDate'])) {
			return false;
		}

		$fromDate = new \DateTime($params['fromDate']);
		$toDate = new \DateTime($params['toDate']);

		$em = $this->getDoctrine()->getManager();
		$dql = "
            select p from AcmePurchaseBundle:Purchase p
            where p.status = 1
            and p.purchaseDate between :fromDate and :toDate
        ";

		$dql .= " order by p.purchaseDate asc";

		$query = $em->createQuery($dql)
		            ->setParameter('fromDate', $fromDate->format('Y-m-d'))
		            ->setParameter('toDate', $toDate->format('Y-m-d'));

		$results = $query->getResult();
		$reportData = array();
		if ($results) {
			foreach ($results as $row) {
				$reportData[] = $row;
			}
		}

		return $reportData;
	}

	public function issueAction() {
		$em = $this->getDoctrine()->getManager();
		$request = $this->get('request');

		$fetchFrom = $request->request->get('from');
		$fetchTo = $request->request->get('to');

		$from = new \DateTime($fetchFrom);
		$to = new \DateTime($fetchTo);

		if ($request->getMethod() == 'POST') {
			$dql = $em->createQueryBuilder();
			$dql->select('il', 'i', 'u')
			    ->from('AcmeIssueBundle:IssueLine', 'il')
			    ->join('il.issue', 'i')
			    ->join('i.createdBy', 'u')
			    ->where("i.issueDate <= '" . $to->format('Y-m-d') . "'")
			    ->andWhere("i.issueDate >= '" . $from->format('Y-m-d') . "'")
			    ->addOrderby('i.issueDate', 'DESC');
			$query = $em->createQuery($dql);
			$results = $query->getResult();

			return $this->render('AcmeReportBundle:Report:_issueReport.html.twig', array(
				'results' => $results,
			));

			// die(\Doctrine\Common\Util\Debug::dump($result));
		}

		return $this->render('AcmeReportBundle:Report:issueReport.html.twig');
	}
}