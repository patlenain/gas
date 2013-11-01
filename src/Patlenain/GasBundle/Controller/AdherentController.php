<?php

namespace Patlenain\GasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Patlenain\GasBundle\Entity\Adherent;
use Patlenain\GasBundle\Form\AdherentType;
use Patlenain\GasBundle\Manager\AdherentManager;
use Symfony\Bridge\Monolog\Logger;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Patlenain\GasBundle\Manager\AnneeManager;
use Patlenain\GasBundle\Form\AdherentRechercheType;

/**
 * @Route("/adherent")
 */
class AdherentController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_adherent_index")
	 * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	return $this->redirect($this->generateUrl("patlenain_gas_adherent_list"), 301);
    }

    /**
     * @Route("/list", name="patlenain_gas_adherent_list")
     * @Template
	 * @Secure(roles="ROLE_USER")
     */
    public function listAction()
    {
    	$request = $this->getRequest();
    	$derniereAnnee = $this->get('patlenain_gas.annee_manager')->getDerniereAnnee();
    	$form = $this->createForm(new AdherentRechercheType($derniereAnnee), array(
    		'action' => $this->generateUrl('patlenain_gas_adherent_list'),
    		'method' => 'post'
    	));
		$form->submit($request, false);
		$adherents = array();
    	if ($form->isValid()) {
    		$data = $form->getData();
    		$adherents = $this->get('patlenain_gas.adherent_manager')->listAdherents(
    			$data['nom'], $data['prenom'], $data['annee']);
    	}
		return array('form' => $form->createView(), 'adherents' => $adherents);
    }

    /**
     * @Route("/show/{adherentId}", name="patlenain_gas_adherent_show")
     * @Template
	 * @Secure(roles="ROLE_USER")
     */
    public function showAction($adherentId) {
		$request = $this->getRequest();
		if (!$adherent = $this->get('patlenain_gas.adherent_manager')->loadAdherent($adherentId))
		{
			throw $this->createNotFoundException('Adhérent inconnu');
		}

		$deleteForm = $this->createDeleteForm($adherentId);
		return array('adherent' => $adherent, 'delete_form' => $deleteForm->createView());
    }

    /**
	 * @Route("/new", name="patlenain_gas_adherent_add")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction()
	{
		$request = $this->getRequest();
		$adherent = new Adherent();
		$form = $this->createForm(new AdherentType(), $adherent, array(
			'action' => $this->generateUrl('patlenain_gas_adherent_add'),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$this->get('patlenain_gas.adherent_manager')->saveAdherent($adherent);
				$this->get('session')->getFlashBag()->add('notice', 'Adhérent ajouté');
				return $this->redirect($this->generateUrl('patlenain_gas_adherent_show',
						array( 'adherentId' => $adherent->getId())));
			}
		}
		return array('form' => $form->createView(), 'adherent' => $adherent);
	}


    /**
	 * @Route("/edit/{adherentId}", name="patlenain_gas_adherent_edit")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction($adherentId)
	{
		$request = $this->getRequest();
		if (!$adherent = $this->get('patlenain_gas.adherent_manager')->loadAdherent($adherentId))
		{
			throw $this->createNotFoundException('Adhérent inconnu');
		}
		$form = $this->createForm(new AdherentType(), $adherent, array(
			'action' => $this->generateUrl('patlenain_gas_adherent_edit',
				array('adherentId' => $adherentId)),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$this->get('patlenain_gas.adherent_manager')->saveAdherent($adherent);
				$this->get('session')->getFlashBag()->add('notice', 'Adhérent modifié');
				return $this->redirect($this->generateUrl('patlenain_gas_adherent_show',
						array( 'adherentId' => $adherentId)));
			}
		}
		return array('form' => $form->createView(), 'adherent' => $adherent);
	}

    /**
	 * @Route("/readhesion/{adherentId}", name="patlenain_gas_adherent_readhesion")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function readhesionAction($adherentId)
	{
		$request = $this->getRequest();
		if (!$adherent = $this->get('patlenain_gas.adherent_manager')->loadAdherent($adherentId))
		{
			throw $this->createNotFoundException('Adhérent inconnu');
		}
		// On détache l'entité pour ne pas la modifier
		$this->getDoctrine()->getManager()->detach($adherent);
		$derniereAnnee = $this->get('patlenain_gas.annee_manager')->getDerniereAnnee();
		$adherent->setAnnee($derniereAnnee);
		$adherent->setDateAdhesion(null);
		$form = $this->createForm(new AdherentType(), $adherent, array(
			'action' => $this->generateUrl('patlenain_gas_adherent_readhesion',
				array('adherentId' => $adherent->getId())),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$adherent = $this->get('patlenain_gas.adherent_manager')->readhesion($adherent);
				$this->get('session')->getFlashBag()->add('notice', 'Réadhésion enregistrée');
				return $this->redirect($this->generateUrl('patlenain_gas_adherent_show',
						array( 'adherentId' => $adherent->getId())));
			}
		}
		return array('form' => $form->createView(), 'adherent' => $adherent);
	}

	/**
	 * @Route("/delete/{adherentId}", name="patlenain_gas_adherent_delete")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function deleteAction($adherentId)
	{
	    $request = $this->getRequest();
		if ($request->isMethod('post'))
		{
			$form = $this->createDeleteForm($adherentId);
	    	$form->submit($request);
			if ($form->isValid())
			{
				if (!$adherent = $this->get('patlenain_gas.adherent_manager')->loadAdherent($adherentId))
				{
					throw $this->createNotFoundException('Adhérent inconnu ' + $adherentId);
				}
				$this->get('patlenain_gas.adherent_manager')->deleteAdherent($adherent);
				$this->get('session')->getFlashBag()->add('notice', 'Adhérent supprimé');
			}
		}
        return $this->redirect($this->generateUrl('patlenain_gas_adherent_list'));
	}

	/**
	 * @param int $adherent
	 * @return Form
	 */
	private function createDeleteForm($adherentId) {
		return $deleteForm = $this->createFormBuilder()
			->setAction($this-> generateUrl('patlenain_gas_adherent_delete', array('adherentId' => $adherentId)))
			->setMethod('post')
			->add('id', 'hidden')->getForm();
	}
}
