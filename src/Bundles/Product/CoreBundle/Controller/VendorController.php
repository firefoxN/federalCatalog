<?php

namespace Bundles\Product\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class VendorController
 *
 * @package Bundles\Product\CoreBundle\Controller
 */
class VendorController extends Controller
{
    /**
     * @Route("/vendors")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return array();
    }
}
