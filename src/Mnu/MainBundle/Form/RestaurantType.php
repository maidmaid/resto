<?php

namespace Mnu\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RestaurantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
	    'label' => 'Nom du resto'
	));
	$builder->add('save', 'submit', array(
	    'label' => 'Enregister'
	));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mnu\MainBundle\Entity\Restaurant'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mnu_mainbundle_restaurant';
    }
}
