<?php

namespace Acme\PurchaseBundle\Datatables;

use TommyGNR\DatatablesBundle\Datatable\View\AbstractDatatableView;
use TommyGNR\DatatablesBundle\Datatable\Theme\BootstrapDatatableTheme;

/**
 * Class PurchaseDatatable
 */
class PurchaseDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatableView()
    {
        $this->setServerSide(true);                        // default
        $this->setAjaxSource($this->getRouter()->generate('post_results'));
        $this->setProcessing(true);                        // default
        $this->setDisplayLength(10);                       // default

        $this->setTheme(BootstrapDatatableTheme::getTheme());
//        $this->setTheme(JqueryUiDatatableTheme::getTheme());
//        $this->setTheme(BaseDatatableTheme::getTheme());

        // Bootstrap theme option: put your datatable in a box
        $this->getTheme()->setPanel();

/*        $this->multiselect->setEnabled(true);               // default = false
        $this->multiselect->setPosition('last');
        $this->multiselect->addAction('Hide', 'post_bulk_disable');
        $this->multiselect->addAction('Delete', 'post_bulk_delete');*/

        $this->columnBuilder
            ->add('id', 'column', array(
                    'title' => 'Id',
                    'searchable' => false
                ))
            ->add('title', 'column', array(
                    'searchable' => true,     // default
                    'sortable' => true,       // default
                    'visible' => true,        // default
//                    'title' => 'Title',     // default = null
                    'title' => $this->getTranslator()->trans('test.title', array(), 'msg'),
                    'render' => null,         // default
                    'class' => 'text-center', // default = ''
                    'default' => null,        // default
                    'width' => null           // default
                ))
            ->add('visible', 'boolean', array(
                    'title' => 'Visible',
                    'true_icon' => BootstrapDatatableTheme::DEFAULT_TRUE_ICON,
                    'false_icon' => BootstrapDatatableTheme::DEFAULT_FALSE_ICON,
                    'true_label' => 'yes',
                    'false_label' => 'no'
                ))
            ->add('createdAt', 'timeago', array(
                    'title' => 'Created'
                ))
//            ->add('createdAt', 'datetime', array(
//                    'title' => 'Created'
//                ))
            ->add('createdBy.username', 'column', array(
                    'title' => 'CreatedBy'
                ))
            ->add('updatedBy.username', 'column', array(
                    'title' => 'UpdatedBy'
                ))
            ->add('tags.name', 'array', array(
                    'title' => 'Tags'
                ))
            ->add(null, 'action', array(
                    'route' => 'post_edit',
                    'parameters' => array(
                        'id' => 'id'
                    ),
                    'renderif' => array(
                        'visible' // if this attribute is not NULL/FALSE
                    ),
                    'icon' => BootstrapDatatableTheme::DEFAULT_EDIT_ICON,
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => 'Edit User',
                        'class' => 'btn btn-danger btn-xs'
                    ),
                ))
            ->add(null, 'action', array(
                    'route' => 'post_show',
                    'parameters' => array(
                        'id' => 'id'
                    ),
//                    'label' => 'Show',
                    'label' => $this->getTranslator()->trans('test.show', array(), 'msg'),
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => 'Show User',
                        'class' => 'btn btn-primary btn-xs'
                    )
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'post_datatable';
    }
}