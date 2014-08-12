<?php

namespace Acme\IssueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime('now');
        $builder
            ->add('issueDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                    'class' => 'date-picker',
                    'value' => $date->format('d-m-Y'),
                )))
            ->add('company', 'entity', array(
                'class' => 'Acme\SetupBundle\Entity\Company'
            ))
            ->add('depot', 'entity', array(
                'class' => 'Acme\SetupBundle\Entity\Depot'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\IssueBundle\Entity\Issue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_issuebundle_issue';
    }
}
