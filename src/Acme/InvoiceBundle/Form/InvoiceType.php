<?php

namespace Acme\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

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
            ->add('invoiceDate','date',array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'label'  => 'Date',
                    'attr' => array(
                        'class' => 'date-picker',
                        'value' => $date->format('d-m-Y')
                    )
                )
            )
            ->add('invoiceStatus', 'choice', array(
                        'label'    => 'Status',
                        'choices'   => array('paid' => 'Paid', 'pending' => 'Pending'),
                        'preferred_choices' => array('Pending')
                )
            )
            ->add('customer','entity',array(
                    'class' => 'Acme\SetupBundle\Entity\Customer',
                    'empty_value' => 'Select customer',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->orderBy('c.name', 'ASC');
                    },
                    'attr' => array('class' => 'chosen-select')
                )
            )
        ;
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
