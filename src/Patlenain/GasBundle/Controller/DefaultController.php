<?php

namespace Patlenain\GasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_index")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        return array();
    }
}
