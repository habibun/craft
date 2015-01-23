<?php

namespace Acme\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceLineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime('now');
        $builder
            ->add('description')
            ->add('unitPrice')
            ->add('quantity')
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\InvoiceBundle\Entity\InvoiceLine'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoice_line';
    }
}
