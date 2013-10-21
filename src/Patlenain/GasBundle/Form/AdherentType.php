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
        	->add('nom', 'text', array(
        			'label' => 'patlenain_gas.adherent.nom',
        			'max_length' => 50))
            ->add('prenom', 'text', array(
            		'label' => 'patlenain_gas.adherent.prenom',
            		'max_length' => 50))
            ->add('adresse', 'textarea', array(
            		'label' => 'patlenain_gas.adherent.adresse',
            		'max_length' => 255,
					'attr' => array('cols' => 60, 'rows' => 4)))
            ->add('codePostal', 'text', array(
            		'label' => 'patlenain_gas.adherent.codePostal',
            		'max_length' => 5))
            ->add('ville', 'text', array(
            		'label' => 'patlenain_gas.adherent.ville',
            		'max_length' => 255))
			->add('email', 'text', array(
            		'label' => 'patlenain_gas.adherent.email',
            		'required' => false,
            		'max_length' => 50))
            ->add('dateNaissance', 'date', array(
            		'widget' => 'single_text',
            		'format' => 'dd/MM/yyyy',
            		'label' => 'patlenain_gas.adherent.dateNaissance'))
            ->add('dateAdhesion', 'date', array(
            		'widget' => 'single_text',
            		'format' => 'dd/MM/yyyy',
            		'label' => 'patlenain_gas.adherent.dateAdhesion',
            		'required' => false))
			->add('annee', 'entity', array(
					'class' => 'PatlenainGasBundle:Annee',
					'property' => 'libelle'))
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
