<?php

namespace TMA\ConferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SessionType extends AbstractType
{
    private $time;

    public function __construct($time = null)
    {
        if ($time === null)
            $this->time = new \DateTime('2013-05-15 09:00');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('time', 'datetime', array(
                'data' => $this->time,
                'time_widget' => 'single_text',
                'date_widget' => 'single_text'
            ))
            ->add('moderator')
            ->add('discussants',null, array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TMA\ConferenceBundle\Entity\Session'
        ));
    }

    public function getName()
    {
        return 'tma_conferencebundle_sessiontype';
    }
}
