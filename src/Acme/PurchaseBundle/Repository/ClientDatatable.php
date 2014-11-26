<?php

namespace Acme\PurchaseBundle\Repository;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;

/**
 * Class ClientDatatable
 *
 * @package Fdelapena\SomeBundle\Datatables
 */
class ClientDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatableView()
    {
        //-------------------------------------------------
        // Datatable
        //-------------------------------------------------
        // Features (defaults)
        $this->getFeatures()
            ->setAutoWidth(true)
            ->setDeferRender(false)
            ->setInfo(true)
            ->setJQueryUI(false)
            ->setLengthChange(true)
            ->setOrdering(true)
            ->setPaging(true)
            ->setProcessing(true)  // default: false
            ->setScrollX(true)     // default: false
            ->setScrollY("")
            ->setSearching(true)
            ->setServerSide(true)  // default: false
            ->setStateSave(false);

        // Options (for more options see file: Sg\DatatablesBundle\Datatable\View\Options.php)
        $this->getOptions()
            ->setLengthMenu(array(10, 25, 50, 100, -1))
            ->setOrder(array("column" => 1, "direction" => "desc"));

        $this->getAjax()->setUrl($this->getRouter()->generate("client_results"));

        $this->getMultiselect()
            ->setEnabled(true)
            ->setPosition("last")
            ->addAction("Activar", "client_bulk_enable")
            ->addAction("Desactivar", "client_bulk_disable");

        $this->setStyle(self::BOOTSTRAP_3_STYLE);

        $this->setIndividualFiltering(true);


        //-------------------------------------------------
        // Columns
        //-------------------------------------------------

        $this->getColumnBuilder()
            ->add("id", "column", array(
                    "title" => "ID",
                    "orderable" => true,
                    "visible" => true
                ))

            ->add(null, "action", array(
                    "route" => "client_edit",
                    "label" => "Acciones",
                    "parameters" => array(
                        "id" => "id"
                    ),
                    "renderif" => array(
                        "visible" // if this attribute is not NULL/FALSE
                    ),
                    "label" => "Editar",
                    "attributes" => array(
                        "rel" => "tooltip",
                        "title" => "Editar usuario",
                        "class" => "btn btn-danger btn-xs"
                    ),
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return "AcmePurchaseBundle:Purchase";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "client_datatable";
    }
}