<?php

namespace Acme\HistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductHistoryController extends Controller
{
	public function productAction()
	{
		return $this->render('AcmeHistoryBundle:ProductHistory:productHistory.html.twig');
	}

	public function productInAction()
    {
        $totalProductIn = $this->_getProductInResults();

        return $this->render(
            'AcmeHistoryBundle:ProductHistory:productInHistory.html.twig',
            array(
                'totalProductIn' => $totalProductIn,
            )
        );
    }

    private function _getProductInResults()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT IDENTITY(pl.product), sum(pl.quantity) as total_product_in,pr.name as name, pu.status as active
             from AcmePurchaseBundle:PurchaseLine pl
             join pl.purchase pu
             join pl.product pr
             where pu.status = 1
             group by pl.product
             order by total_product_in DESC
             '
        );
        $result = $query->getResult();
        return $result;
    } 

    public function productOutAction()
    {
        $totalProductOut = $this->_getProductOutResults();

        return $this->render(
            'AcmeHistoryBundle:ProductHistory:productOutHistory.html.twig',
            array(
                'totalProductOut' => $totalProductOut,
            )
        );
    }

    private function _getProductOutResults()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT IDENTITY(i.product), sum(i.quantity) as total_product_out, pro.name as name, iss.status as active
             from AcmeIssueBundle:IssueLine i
             join i.issue iss
             join i.product pro
             where iss.status = 1
             group by i.product
             order by total_product_out DESC
             '
        );
        $result = $query->getResult();
        return $result;
    }
}