<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Acme\UserBundle\AcmeUserBundle(),
            new Acme\DashBundle\AcmeDashBundle(),
            new Acme\SetupBundle\AcmeSetupBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Acme\PurchaseBundle\AcmePurchaseBundle(),
            new LanKit\DatatablesBundle\LanKitDatatablesBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Acme\IssueBundle\AcmeIssueBundle(),
            new Acme\ReportBundle\AcmeReportBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new Acme\HistoryBundle\AcmeHistoryBundle(),
            new Kitpages\DataGridBundle\KitpagesDataGridBundle(),
            new Acme\WidgetBundle\AcmeWidgetBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Cg\KintBundle\CgKintBundle(),
            new Ali\DatatableBundle\AliDatatableBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
