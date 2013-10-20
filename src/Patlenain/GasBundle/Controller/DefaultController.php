<?php

namespace Patlenain\GasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="patlenain_gas_index")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('patlenain_gas_adherent_index'));
    }
}
