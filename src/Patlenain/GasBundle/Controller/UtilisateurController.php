<?php

namespace Patlenain\GasBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Patlenain\GasBundle\Entity\Utilisateur;
use Patlenain\GasBundle\Form\UtilisateurEditType;
use Patlenain\GasBundle\Form\UtilisateurNewType;
use Patlenain\GasBundle\Manager\UtilisateurManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_utilisateur_index")
	 * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
    	return $this->redirect($this->generateUrl("patlenain_gas_utilisateur_list"), 301);
    }

    /**
     * @Route("/list", name="patlenain_gas_utilisateur_list")
     * @Template
	 * @Secure(roles="ROLE_ADMIN")
     */
    public function listAction()
    {
		$utilisateurs = $this->get('patlenain_gas.utilisateur_manager')->listAll();
		return array('utilisateurs' => $utilisateurs);
    }

    /**
     * @Route("/show/{utilisateurId}", name="patlenain_gas_utilisateur_show")
     * @Template
	 * @Secure(roles="ROLE_ADMIN")
     */
    public function showAction($utilisateurId) {
		$request = $this->get('request');
		if (!$utilisateur = $this->get('patlenain_gas.utilisateur_manager')->loadUtilisateur($utilisateurId))
		{
			throw $this->createNotFoundException('Utilisateur inconnu ' + $utilisateurId);
		}

		$deleteForm = $this->createDeleteForm($utilisateurId);
		return array('utilisateur' => $utilisateur, 'delete_form' => $deleteForm->createView());
    }

    /**
	 * @Route("/new", name="patlenain_gas_utilisateur_add")
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function newAction()
	{
		$request = $this->get('request');
		$utilisateur = new Utilisateur();
		$form = $this->createForm(new UtilisateurNewType(), $utilisateur, array(
			'action' => $this->generateUrl('patlenain_gas_utilisateur_add'),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$newPassword = $utilisateur->getPassword();
				$encoder = $this->get('security.encoder_factory')->getEncoder($utilisateur);
				$utilisateur->setPassword($encoder->encodePassword($newPassword, $utilisateur->getSalt()));
				$this->get('patlenain_gas.utilisateur_manager')->saveUtilisateur($utilisateur);
				$this->get('session')->getFlashBag()->add('notice', 'Utilisateur ajouté');
				return $this->redirect($this->generateUrl('patlenain_gas_utilisateur_show',
						array( 'utilisateurId' => $utilisateur->getId())));
			}
		}
		return array('form' => $form->createView(), 'utilisateur' => $utilisateur);
	}


    /**
	 * @Route("/edit/{utilisateurId}", name="patlenain_gas_utilisateur_edit")
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function editAction($utilisateurId)
	{
		$request = $this->get('request');
		if (!$utilisateur = $this->get('patlenain_gas.utilisateur_manager')->loadUtilisateur($utilisateurId))
		{
			throw $this->createNotFoundException('Utilisateur inconnu ' + $utilisateurId);
		}
		$oldPassword = $utilisateur->getPassword();
		$form = $this->createForm(new UtilisateurEditType(), $utilisateur, array(
			'action' => $this->generateUrl('patlenain_gas_utilisateur_edit',
				array('utilisateurId' => $utilisateurId)),
			'method' => 'post'
		));
		if ($request->isMethod('post'))
		{
			$form->submit($request);
			if ($form->isValid())
			{
				$newPassword = $utilisateur->getPassword();
				if (empty($newPassword))
				{
					$utilisateur->setPassword($oldPassword);
				}
				else
				{
					$encoder = $this->get('security.encoder_factory')->getEncoder($utilisateur);
					$utilisateur->setPassword($encoder->encodePassword($newPassword, $utilisateur->getSalt()));
				}
				$this->get('patlenain_gas.utilisateur_manager')->saveUtilisateur($utilisateur);
				$this->get('session')->getFlashBag()->add('notice', 'Utilisateur modifié');
				return $this->redirect($this->generateUrl('patlenain_gas_utilisateur_show',
						array( 'utilisateurId' => $utilisateurId)));
			}
		}
		return array('form' => $form->createView(), 'utilisateur' => $utilisateur);
	}

	/**
	 * @Route("/delete/{utilisateurId}", name="patlenain_gas_utilisateur_delete")
	 * @Template()
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function deleteAction($utilisateurId)
	{
	    $request = $this->get('request');
		if ($request->isMethod('post'))
		{
			$form = $this->createDeleteForm($utilisateurId);
	    	$form->submit($request);
			if ($form->isValid())
			{
				if (!$utilisateur = $this->get('patlenain_gas.utilisateur_manager')->loadUtilisateur($utilisateurId))
				{
					throw $this->createNotFoundException('Utilisateur inconnu ' + $anneeId);
				}
				$this->get('patlenain_gas.utilisateur_manager')->deleteUtilisateur($utilisateur);
				$this->get('session')->getFlashBag()->add('notice', 'Utilisateur supprimé');
			}
		}
        return $this->redirect($this->generateUrl('patlenain_gas_utilisateur_list'));
	}

	/**
	 * @param int $utilisateurId
	 * @return Form
	 */
	private function createDeleteForm($utilisateurId) {
		return $deleteForm = $this->createFormBuilder()
			->setAction($this-> generateUrl('patlenain_gas_utilisateur_delete',
					array('utilisateurId' => $utilisateurId)))
			->setMethod('post')
			->add('id', 'hidden')->getForm();
	}
}
