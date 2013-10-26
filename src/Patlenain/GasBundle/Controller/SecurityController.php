<?php

namespace Patlenain\GasBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Patlenain\GasBundle\Form\UtilisateurPreferencesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Translation\IdentityTranslator;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="patlenain_gas_login")
     * @Template()
     */
    public function loginAction()
    {
    	$request = $this->getRequest();
    	$session = $request->getSession();
    	// get the login error if there is one
    	if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
    		$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    	}
    	else {
    		$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
    		$session->remove(SecurityContext::AUTHENTICATION_ERROR);
    	}
    	if (!empty($error)) {
			$this->get('session')->getFlashBag()->add('error', $error->getMessage());
    	}
	   	return array(
    		'username' => $session->get(SecurityContext::LAST_USERNAME)
    	);
    }

    /**
     * @Route("/login_check", name="patlenain_gas_login_check")
     */
    public function loginCheckAction()
    {
    	return array();
    }

    /**
     * @Route("/logout", name="patlenain_gas_logout")
     * @Template()
     */
    public function logoutAction()
    {
    	return array();
    }

	/**
	 * @Route("/preferences", name="patlenain_gas_preferences")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function preferencesAction()
	{
		$request = $this->get('request');
		$utilisateur = $this->getUser();
		$oldPassword = $utilisateur->getPassword();
		$form = $this->createForm(new UtilisateurPreferencesType(), $utilisateur, array(
			'action' => $this->generateUrl('patlenain_gas_preferences'),
			'method' => 'post'
		));
		if ($request->isMethod('post')) {
			$form->submit($request);
			if ($form->isValid()) {
				$newPassword = $utilisateur->getPassword();
				if (empty($newPassword)) {
					$utilisateur->setPassword($oldPassword);
				}
				else {
					$encoder = $this->get('security.encoder_factory')->getEncoder($utilisateur);
					$utilisateur->setPassword($encoder->encodePassword($newPassword, $utilisateur->getSalt()));
				}
				$this->get('patlenain_gas.utilisateur_manager')->saveUtilisateur($utilisateur);
				$this->get('session')->getFlashBag()->add('notice', "Préférences modifiées");
			}
		}
		return array('form' => $form->createView(),
				'user' => $utilisateur);
	}
}
