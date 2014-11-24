<?php

namespace Acme\PurchaseBundle\Repository;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;

/**
 * Class ClientDatatable
 *
 * @package Fdelapena\SomeBundle\Datatables
 */
class PostDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatableView()
    {
        $this->getFeatures()
            ->setServerSide(true)
            ->setProcessing(true);

        $this->getAjax()->setUrl($this->getRouter()->generate("post_results"));

        $this->getMultiselect()
            ->setEnabled(true)
            ->setPosition("last")
            ->setWidth("0.875em")
            ->setClassName("multiselect-checkbox-cell")
            ->addAction($this->getTranslator()->trans("Disable selected Posts"), "Post_bulk_disable")
            ->addAction($this->getTranslator()->trans("Enable selected Posts"), "Post_bulk_enable")
            ->addAction($this->getTranslator()->trans("Delete selected Posts"), "Post_bulk_delete");

        $this->setStyle(self::BOOTSTRAP_3_STYLE);

        $this->getColumnBuilder()
            ->add('id', 'column', array('title' => $this->getTranslator()->trans('Id'),))
            ->add('status', 'boolean', array(
                    "title" => $this->getTranslator()->trans("Enabled"),
                    "true_icon" => "glyphicon glyphicon-ok",
                    "false_icon" => "glyphicon glyphicon-remove",
                    "true_label" => $this->getTranslator()->trans("Yes"),
                    "false_label" => $this->getTranslator()->trans("No"),
                ))
            ->add(null, "action", array(
                    "title" => $this->getTranslator()->trans("Actions"),
                    "start" => '<span class="btn-group">',
                    "end" => '</span>',
                    "class" => "action-cell",
                    "width" => "11em",
                    "actions" => array(
                        array(
                            "route" => "Post_show",
                            "route_parameters" => array(
                                "id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-eye-open",
                            "attributes" => array(
                                "data-toggle" => "tooltip",
                                "title" => $this->getTranslator()->trans("Show"),
                                "class" => "btn btn-default",
                                "role" => "button"
                            ),
                            "role" => "ROLE_ADMIN",
                        ),
                        array(
                            "route" => "Post_edit",
                            "route_parameters" => array(
                                "id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-edit",
                            "attributes" => array(
                                "data-toggle" => "tooltip",
                                "title" => $this->getTranslator()->trans("Edit"),
                                "class" => "btn btn-default",
                                "role" => "button"
                            ),
                            "role" => "ROLE_ADMIN",
                        ),
                        array(
                            "route" => "Post_disable",
                            "route_parameters" => array(
                                "id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-ban-circle",
                            "attributes" => array(
                                "data-toggle" => "tooltip",
                                "title" => $this->getTranslator()->trans("Disable"),
                                "class" => "btn btn-default",
                                "role" => "button"
                            ),
                            "role" => "ROLE_USER",
                            "renderif" => array("enabled"),
                        ),
                        array(
                            "route" => "Post_enable",
                            "route_parameters" => array(
                                "id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-ok-circle",
                            "attributes" => array(
                                "data-toggle" => "tooltip",
                                "title" => $this->getTranslator()->trans("Enable"),
                                "class" => "btn btn-default",
                                "role" => "button"
                            ),
                            "role" => "ROLE_USER",
                            "renderif" => array("enabled) == false; var dummy = function(){}; dummy("),
                        ),
                        array(
                            "route" => "Post_delete",
                            "route_parameters" => array(
                                "id" => "id"
                            ),
                            "icon" => "glyphicon glyphicon-trash",
                            "attributes" => array(
                                "data-toggle" => "tooltip",
                                "title" => $this->getTranslator()->trans("Delete"),
                                "class" => "btn btn-default",
                                "role" => "button"
                            ),
                            "confirm" => true,
                            "confirm_message" => $this->getTranslator()->trans("This operation will erase the Post, all its groups and all their contacts"),
                            "role" => "ROLE_ADMIN",
                        )
                    )
                ))
        ;
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
        return "Post_datatable";
    }
}