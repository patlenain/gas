<?php

namespace Patlenain\GasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurNewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('username', 'text', array(
        			'label' => 'patlenain_gas.utilisateur.username',
        			'required' => true,
        			'max_length' => 32))
        	->add('nom', 'text', array(
        			'label' => 'patlenain_gas.utilisateur.nom',
        			'required' => true,
        			'max_length' => 255))
        	->add('email', 'text', array(
        			'label' => 'patlenain_gas.utilisateur.email',
        			'required' => true,
        			'max_length' => 255))
        	->add('password', 'repeated', array(
        			'required' => true,
        			'max_length' => 255,
        			'type' => 'password',
        			'invalid_message' => 'patlenain_gas.utilisateur.passwordMustMatch',
        			'first_options' => array(
        				'label' => 'patlenain_gas.utilisateur.password'),
        			'second_options' => array(
        				'label' => 'patlenain_gas.utilisateur.password2')))
        	->add('admin', 'checkbox', array(
        			'label' => 'patlenain_gas.utilisateur.admin',
        			'required' => false))
        	->add('save', 'submit', array(
            		'label' => 'patlenain_gas.common.save',
            		'attr' => array('class' => 'bouton')))
            ->add('reset', 'reset', array(
            		'label' => 'patlenain_gas.common.cancel',
            		'attr' => array('class' => 'bouton')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Patlenain\GasBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'patlenain_gasbundle_utilisateur_new';
    }
}
