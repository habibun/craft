<?php

namespace Acme\EmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    protected $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                'genemu_jqueryautocomplete_entity',
                array(
                    'class' => $this->className,
                    'property' => 'email',
                )
            );
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_emailbundle_search';
    }
}
