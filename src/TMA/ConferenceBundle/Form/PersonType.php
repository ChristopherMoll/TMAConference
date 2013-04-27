<?php

namespace TMA\ConferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('organization')
            ->add('bio')
            ->add('picture')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TMA\ConferenceBundle\Entity\Person'
        ));
    }

    public function getName()
    {
        return 'tma_conferencebundle_persontype';
    }
}
