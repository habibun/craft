<?php

namespace Acme\DashBundle\Twig;

class StatusExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'status' => new \Twig_Filter_Method($this, 'statusFilter'),
        );
    }

    public function statusFilter($status)
    {
        if($status){
            $label='<span class="label label-inverse label-mini">Enabled</span>';
        }else{
            $label='<span class="label label-warning label-mini">Disabled</span>';
        }
        return $label;
    }

    public function getName()
    {
        return "status_extension";
    }
}