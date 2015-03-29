<?php

namespace Acme\DashBundle\Twig;

class PanchShopExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'price' => new \Twig_Filter_Method($this, 'priceFilter'),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = 'Tk.' . $price;

        return $price;
    }

    public function getName()
    {
        return 'panch_shop_extension';
    }
}
