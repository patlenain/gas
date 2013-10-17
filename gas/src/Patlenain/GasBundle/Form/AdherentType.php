<?php

namespace Patlenain\GasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdherentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
        	->add('nom', 'text', array('label' => 'patlenain_gas.adherent.nom'))
            ->add('prenom', 'text', array('label' => 'patlenain_gas.adherent.prenom'))
            ->add('email', 'text', array('label' => 'patlenain_gas.adherent.email'))
            ->add('dateNaissance', 'birthday', array(
            		'widget' => 'single_text',
            		'format' => 'dd/MM/yyyy',
            		'label' => 'patlenain_gas.adherent.dateNaissance'))
            ->add('dateAdhesion', 'date', array(
            		'widget' => 'single_text',
            		'format' => 'dd/MM/yyyy',
            		'label' => 'patlenain_gas.adherent.dateAdhesion'))
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
            'data_class' => 'Patlenain\GasBundle\Entity\Adherent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'patlenain_gasbundle_adherent';
    }
}
