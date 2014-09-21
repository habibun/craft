<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 9/15/14
 * Time: 10:12 AM
 */

namespace Acme\HistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kitpages\DataGridBundle\Model\GridConfig;
use Kitpages\DataGridBundle\Model\Field;
use Kitpages\DataGridBundle\Model\PaginatorConfig;

class HistoryController extends Controller
{

    public function purchaseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select(array('p', 'pr', 'pu', 'su', 'us', 'use', 'user'))
            ->from('AcmePurchaseBundle:PurchaseLine', 'p')
            ->leftJoin('p.product', 'pr')
            ->leftJoin('p.purchase', 'pu')
            ->leftJoin('pu.supplier', 'su')
            ->leftJoin('pu.createdBy', 'us')
            ->leftJoin('pu.updatedBy', 'use')
            ->leftJoin('pu.finalizedBy', 'user')
            ->add('orderBy', 'p.id ASC');

        $gridConfig = new GridConfig();
        $gridConfig
            ->setQueryBuilder($queryBuilder)
            ->setCountFieldName('p.id')
            ->addField(new Field('p.id', array('label' => 'Transaction No', 'filterable' => true)))
            ->addField(new Field('p.product.name', array('label' => 'Product')))
            ->addField(new Field('p.quantity', array('label' => 'Quantity')))
            ->addField(new Field('p.price', array('label' => 'Price')))
            ->addField(
                new Field('p.purchase.purchaseDate', array(
                    'label' => 'Purchase Date',
                    'formatValueCallback' => function ($value) {
                            return $value->format('Y/m/d');
                        }
                )))
            ->addField(new Field('p.purchase.supplier.name', array('label' => 'Supplier')))
            ->addField(new Field('p.purchase.createdAt', array('label' => 'Created At')))
            ->addField(new Field('p.purchase.createdBy.username', array('label' => 'Created By')))
            ->addField(new Field('p.purchase.updatedAt', array('label' => 'Updated At')))
            ->addField(new Field('p.purchase.updatedBy', array(
                    'label' => 'Updated By',
                    'nullIfNotExists' => true,
                    'formatValueCallback' => function ($updatedBy) {
                            if (isset($updatedBy['username'])) {
                                return $updatedBy['username'];
                            }
                        }
                ))
            )
            ->addField(new Field('p.purchase.finalizedAt', array(
                    'label' => 'Finalized At',
                    'nullIfNotExists' => true,
                ))
            )
            ->addField(new Field('p.purchase.finalizedBy', array(
                    'label' => 'Finalized By',
                    'nullIfNotExists' => true,
                    'formatValueCallback' => function ($finalizedBy) {
                            if (isset($finalizedBy['username'])) {
                                return $finalizedBy['username'];
                            }
                        }
                ))
            );
        // paginator configuration
        $gridPaginatorConfig = new PaginatorConfig();
        $gridPaginatorConfig
            ->setName($gridConfig->getName())
            ->setCountFieldName($gridConfig->getCountFieldName())
            ->setItemCountInPage(10);
        $gridConfig->setPaginatorConfig($gridPaginatorConfig);

        $gridManager = $this->get('kitpages_data_grid.manager');
        //instead of getRequest
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $this->get('request_stack')->getCurrentRequest());

        return $this->render(
            'AcmeHistoryBundle:History:purchaseHistory.html.twig',
            array(
                'grid' => $grid
            )
        );
    }

    public function issueAction()
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select(array('i', 'pr', 'iss', 'co', 'de', 'cr', 'up', 'fin'))
            ->from('AcmeIssueBundle:IssueLine', 'i')
            ->leftJoin('i.product', 'pr')
            ->leftJoin('i.issue', 'iss')
            ->leftJoin('iss.company', 'co')
            ->leftJoin('iss.depot', 'de')
            ->leftJoin('iss.createdBy', 'cr')
            ->leftJoin('iss.updatedBy', 'up')
            ->leftJoin('iss.finalizedBy', 'fin')
            ->add('orderBy', 'i.referenceNumber ASC');


        $gridConfig = new GridConfig();
        $gridConfig
            ->setQueryBuilder($queryBuilder)
            ->setCountFieldName('i.id')
            ->addField(new Field('i.referenceNumber', array('label' => 'Reference No', 'filterable' => true)))
            ->addField(new Field('i.product.name', array('label' => 'Product')))
            ->addField(new Field('i.quantity', array('label' => 'Quantity')))
            ->addField(new Field('i.issueTo', array('label' => 'Issue To')))
            ->addField(
                new Field('i.issue.issueDate', array(
                    'label' => 'Issue Date',
                    'formatValueCallback' => function ($value) {
                            return $value->format('Y/m/d');
                        }
                )))
            ->addField(new Field('i.issue.company.name', array('label' => 'To Company')))
            ->addField(new Field('i.issue.depot.name', array('label' => 'To Depot')))
            ->addField(new Field('i.issue.createdAt', array('label' => 'Created At')))
            ->addField(new Field('i.issue.createdBy.username', array('label' => 'Created By')))
            ->addField(
                new Field('i.issue.updatedAt', array(
                    'label' => 'Updated At',
                    'nullIfNotExists' => true,
                ))
            )
            ->addField(
                new Field('i.issue.updatedBy', array(
                    'label' => 'Updated By',
                    'nullIfNotExists' => true,
                    'formatValueCallback' => function ($updatedBy) {
                            if (isset($updatedBy['username'])) {
                                return $updatedBy['username'];
                            }
                        }
                ))
            )
            ->addField(
                new Field('i.issue.finalizedAt', array(
                    'label' => 'Finalized At',
                    'nullIfNotExists' => true,
                ))
            )
            ->addField(
                new Field('i.issue.finalizedBy', array(
                    'label' => 'Finalized By',
                    'nullIfNotExists' => true,
                    'formatValueCallback' => function ($finalizedBy) {
                            if (isset($finalizedBy['username'])) {
                                return $finalizedBy['username'];
                            }
                        }
                ))
            );
        // paginator configuration
        $gridPaginatorConfig = new PaginatorConfig();
        $gridPaginatorConfig
            ->setName($gridConfig->getName())
            ->setCountFieldName($gridConfig->getCountFieldName())
            ->setItemCountInPage(10);
        $gridConfig->setPaginatorConfig($gridPaginatorConfig);

        $gridManager = $this->get('kitpages_data_grid.manager');
        //instead of getRequest
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $this->get('request_stack')->getCurrentRequest());

        return $this->render(
            'AcmeHistoryBundle:History:issueHistory.html.twig',
            array(
                'grid' => $grid
            )
        );
    }

}