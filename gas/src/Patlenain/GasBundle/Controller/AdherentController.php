<?php

namespace Patlenain\GasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Patlenain\GasBundle\Entity\Adherent;
use Patlenain\GasBundle\Form\AdherentType;
use Patlenain\GasBundle\Manager\AdherentManager;
use Symfony\Bridge\Monolog\Logger;
use Patlenain\GasBundle\Form\AdherentDeleteType;

/**
 * @Route("/adherent")
 */
class AdherentController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_adherent_index")
     */
    public function indexAction()
    {
    	return $this->redirect($this->generateUrl("patlenain_gas_adherent_list"), 301);
    }

    /**
     * @Route("/list", name="patlenain_gas_adherent_list")
     * @Template
     */
    public function listAction()
    {
		$adherents = $this->get('patlenain_gas.adherent_manager')->listAdherents();
		return array('adherents' => $adherents);
    }

    /**
     * @Route("/show/{adherentId}", name="patlenain_gas_adherent_show")
     * @Template
     */
    public function showAction($adherentId) {
		$request = $this->get('request');
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
	 */
	public function newAction()
	{
		$request = $this->get('request');
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
						array( 'adherentId' => $adherent->id)));
			}
		}
		return array('form' => $form->createView(), 'adherent' => $adherent);
	}


    /**
	 * @Route("/edit/{adherentId}", name="patlenain_gas_adherent_edit")
	 * @Template()
	 */
	public function editAction($adherentId)
	{
		$request = $this->get('request');
		if (!$adherent = $this->get('patlenain_gas.adherent_manager')->loadAdherent($adherentId))
		{
			throw $this->createNotFoundException('Adhérent inconnu');
		}
		$form = $this->createForm(new AdherentType(), $adherent, array(
			'action' => $this->generateUrl('patlenain_gas_adherent_edit'),
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
	 * @Route("/delete/{adherentId}", name="patlenain_gas_adherent_delete")
	 * @Method("post")
	 */
	public function deleteAction($adherentId)
	{
	    $request = $this->get('request');
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
