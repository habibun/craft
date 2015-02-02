<?php

namespace Acme\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime('now');
        $builder
            // ->add('name', null, array('label' => false))  --if do not need to label
            ->add('name')
            ->add('address','textarea')
            ->add('invoiceDate','date',
                array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'label'  => 'Date',
                    'attr' => array(
                        'class' => 'date-picker',
                        'value' => $date->format('d-m-Y')
                    ))
                )
            ->add('invoiceStatus', 'choice', array(
                        'label'    => 'Status',
                        'choices'   => array('paid' => 'Paid', 'pending' => 'Pending'),
                        'preferred_choices' => array('paid'))
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\InvoiceBundle\Entity\Invoice'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_invoicebundle_invoice';
    }
}
