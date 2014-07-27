<?php

namespace Acme\PurchaseBundle\Form;


use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PurchaseType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->securityContext->getToken()->getUser();
        $date = new \DateTime('now');
        $builder
            ->add(
                'purchaseDate',
                'date',
                array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array(
                        'class' => 'date-picker',
                        'value' => $date->format('d-m-Y'),
                    )
                )
            )
            ->add(
                'company',
                'entity',
                array(
                    'class' => 'Acme\SetupBundle\Entity\Company'
                )
            )
            ->add(
                'depot',
                'entity',
                array(
                    'class' => 'Acme\SetupBundle\Entity\Depot'
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
                'data_class' => 'Acme\PurchaseBundle\Entity\Purchase',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_purchasebundle_purchase';
    }
}
