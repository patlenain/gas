<?php

namespace Patlenain\GasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Patlenain\GasBundle\Entity\Annee;
use Patlenain\GasBundle\Form\AnneeType;
use Patlenain\GasBundle\Manager\AnneeManager;
use Symfony\Bridge\Monolog\Logger;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/annee")
 */
class AnneeController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_annee_index")
	 * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	return $this->redirect($this->generateUrl("patlenain_gas_annee_list"), 301);
    }

    /**
     * @Route("/list", name="patlenain_gas_annee_list")
     * @Template
	 * @Secure(roles="ROLE_USER")
     */
    public function listAction()
    {
		$annees = $this->get('patlenain_gas.annee_manager')->listAnnees();
		return array('annees' => $annees);
    }

    /**
     * @Route("/show/{anneeId}", name="patlenain_gas_annee_show")
     * @Template
	 * @Secure(roles="ROLE_USER")
     */
    public function showAction($anneeId) {
		$request = $this->get('request');
		if (!$annee = $this->get('patlenain_gas.annee_manager')->loadAnnee($anneeId))
		{
			throw $this->createNotFoundException('Année inconnue ' + $anneeId);
		}

		$deleteForm = $this->createDeleteForm($anneeId);
		return array('annee' => $annee, 'delete_form' => $deleteForm->createView());
    }

    /**
	 * @Route("/new", name="patlenain_gas_annee_add")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction()
	{
		$request = $this->get('request');
		$annee = new Annee();
		$form = $this->createForm(new AnneeType(), $annee, array(
			'action' => $this->generateUrl('patlenain_gas_annee_add'),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$this->get('patlenain_gas.annee_manager')->saveAnnee($annee);
				$this->get('session')->getFlashBag()->add('notice', 'Année ajoutée');
				return $this->redirect($this->generateUrl('patlenain_gas_annee_show',
						array( 'anneeId' => $annee->getId())));
			}
		}
		return array('form' => $form->createView(), 'annee' => $annee);
	}


    /**
	 * @Route("/edit/{anneeId}", name="patlenain_gas_annee_edit")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction($anneeId)
	{
		$request = $this->get('request');
		if (!$annee = $this->get('patlenain_gas.annee_manager')->loadAnnee($anneeId))
		{
			throw $this->createNotFoundException('Année inconnue ' + $anneeId);
		}
		$form = $this->createForm(new AnneeType(), $annee, array(
			'action' => $this->generateUrl('patlenain_gas_annee_edit',
				array('anneeId' => $anneeId)),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$this->get('patlenain_gas.annee_manager')->saveAnnee($annee);
				$this->get('session')->getFlashBag()->add('notice', 'Année modifiée');
				return $this->redirect($this->generateUrl('patlenain_gas_annee_show',
						array( 'anneeId' => $anneeId)));
			}
		}
		return array('form' => $form->createView(), 'annee' => $annee);
	}

	/**
	 * @Route("/delete/{anneeId}", name="patlenain_gas_annee_delete")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function deleteAction($anneeId)
	{
	    $request = $this->get('request');
		if ($request->isMethod('post'))
		{
			$form = $this->createDeleteForm($anneeId);
	    	$form->submit($request);
			if ($form->isValid())
			{
				if (!$annee = $this->get('patlenain_gas.annee_manager')->loadAnnee($anneeId))
				{
					throw $this->createNotFoundException('Année inconnue ' + $anneeId);
				}
				$this->get('patlenain_gas.annee_manager')->deleteAnnee($annee);
				$this->get('session')->getFlashBag()->add('notice', 'Année supprimée');
			}
		}
        return $this->redirect($this->generateUrl('patlenain_gas_annee_list'));
	}

	/**
	 * @param int $annee
	 * @return Form
	 */
	private function createDeleteForm($anneeId) {
		return $deleteForm = $this->createFormBuilder()
			->setAction($this-> generateUrl('patlenain_gas_annee_delete', array('anneeId' => $anneeId)))
			->setMethod('post')
			->add('id', 'hidden')->getForm();
	}
}
