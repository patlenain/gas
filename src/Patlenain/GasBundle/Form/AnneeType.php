<?php

namespace Patlenain\GasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnneeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('libelle', 'text', array(
        			'label' => 'patlenain_gas.annee.libelle',
        			'max_length' => 50))
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
            'data_class' => 'Patlenain\GasBundle\Entity\Annee'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'patlenain_gasbundle_annee';
    }
}
