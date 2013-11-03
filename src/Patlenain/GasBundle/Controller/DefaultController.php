<?php

namespace Patlenain\GasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_index")
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	return $this->redirect($this->generateUrl('patlenain_gas_adherent_list'));
    }

    /**
     * @Route("/apropos", name="patlenain_gas_apropos")
     * @Secure(roles="ROLE_USER")
     */
    public function aproposAction()
    {
    	$locale = $this->getRequest()->getLocale();
    	return $this->render('PatlenainGasBundle:Default:apropos.'.$locale.'.html.twig');
    }
}
