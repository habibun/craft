<?php

namespace Acme\IssueBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueLineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceNumber','integer',array(
                    'label' => "Reference no"
                ))
            ->add('issueTo','text',array(
                    'label' => 'Issue to'
                ))
            ->add(
                'product',
                'entity',
                array(
                    'class' => 'Acme\SetupBundle\Entity\Product',
                    'empty_value' => 'Select Product',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('p')
                                ->orderBy('p.name', 'ASC');
                        },
                    'attr' => array('class' => 'chosen-select')
                )
            )
            ->add('quantity');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Acme\IssueBundle\Entity\IssueLine'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'issue_line';
    }
}
