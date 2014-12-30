<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 9/13/14
 * Time: 12:05 PM
 */
namespace Acme\DashBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class MyTwigExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            'camelize' => new Twig_Filter_Method($this, 'camelizeFilter'),
        );
    }

    public function camelizeFilter($value)
    {
        if(!is_string($value)) {
            return $value;
        }

        $chunks    = explode(' ', $value);
        $ucfirsted = array_map(function($s) { return ucfirst($s); }, $chunks);

        return implode('', $ucfirsted);
    }

    public function getName()
    {
        return 'my_twig_extension';
    }
}
