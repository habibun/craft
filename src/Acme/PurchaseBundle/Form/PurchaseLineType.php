<?php

namespace Acme\PurchaseBundle\Form;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PurchaseLineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product','entity', array(
                    'class' => 'Acme\SetupBundle\Entity\Product',
                    'empty_value' => 'Select Product',
                    'attr' => array('class' => 'chosen-select')
                ))
            ->add('quantity')
            ->add('price')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\PurchaseBundle\Entity\PurchaseLine'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'purchase_line';
    }
} 