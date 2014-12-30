<?php

namespace Acme\EmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add(
                'status',
                'checkbox',
                array(
                    'attr' => array('checked' => 'checked')
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Acme\EmailBundle\Entity\Email'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_emailbundle_email';
    }
}
