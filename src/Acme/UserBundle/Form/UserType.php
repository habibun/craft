<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    protected $rolesChoices;

    public function __construct($rolesChoices)
    {
        $this->rolesChoices = $rolesChoices;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('password')
            ->add(
                'enabled',
                'checkbox',
                array(
                    'attr' => array(
                        'align_with_widget' => true,
                    )
                )
            )
            ->add(
                'roles',
                'choice',
                array(
                    'choices' => $this->_flattenArray($this->rolesChoices),
                    'multiple' => true,
                    'empty_value' => false,
                    'expanded' => false,
                    'required' => true,
                    'attr' => array('class' => 'chosen-select')
                ))
            ->add('file');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Acme\UserBundle\Entity\User'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_userbundle_user';
    }

    private function _flattenArray(array $data)
    {
        $returnData = array();

        foreach ($data as $key => $value) {
            $tempValue = str_replace("ROLE_", '', $key);
            $tempValue = ucwords(strtolower(str_replace("_", ' ', $tempValue)));
            $returnData[$key] = $tempValue;
        }

        return $returnData;
    }
}
