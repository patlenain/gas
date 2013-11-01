<?php

namespace Patlenain\GasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Patlenain\GasBundle\Entity\Annee;

class AdherentRechercheType extends AbstractType
{
	/**
	 * @var Annee
	 */
	private $derniereAnnee;

	/**
	 * @param Annee $derniereAnnee
	 */
	public function __construct($derniereAnnee) {
		$this->derniereAnnee = $derniereAnnee;
	}

	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('nom', 'text', array(
        			'label' => 'patlenain_gas.adherent.nom',
        			'max_length' => 50,
        			'required' => false))
            ->add('prenom', 'text', array(
            		'label' => 'patlenain_gas.adherent.prenom',
            		'max_length' => 50,
            		'required' => false))
			->add('annee', 'entity', array(
					'class' => 'PatlenainGasBundle:Annee',
					'property' => 'libelle',
					'data' => $this->derniereAnnee,
					'required' => false))
            ->add('recherche', 'submit', array(
            		'label' => 'patlenain_gas.common.rechercher',
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
            'data_class' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'patlenain_gasbundle_adherent_recherche';
    }
}
