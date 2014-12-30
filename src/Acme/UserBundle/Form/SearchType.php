<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    protected $className;

    public function __construct ($className)
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
            ->add('username', 'genemu_jqueryautocomplete_entity', array(
            'class' => $this->className,
            'property' => 'username',
        ));
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_userbundle_search';
    }
}
