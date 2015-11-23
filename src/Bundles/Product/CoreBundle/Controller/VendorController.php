<?php

namespace Bundles\Product\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VendorController
 *
 * @Route("/vendors")
 */
class VendorController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        //@TODO добавить пагинацию

        $vendors = $this->getVendorManager()->findAll();

        return array(
            'vendors' => $vendors,
        );
    }

    /**
     * Show a vendor
     *
     * @param string $slug
     *
     * @Route("/{slug}")
     * @Template()
     *
     * @return array
     */
    public function showAction($slug)
    {
        //@TODO Добавить изображения к поставщику

        $vendor = $this->getVendorManager()->findBySlug($slug);

        return array(
            'vendor' => $vendor,
        );
    }

    /**
     * Get service "Vendor manager"
     *
     * @return \Bundles\Product\CoreBundle\Services\VendorManager
     */
    private function getVendorManager()
    {
        return $this->get('vendor_manager');
    }
}
