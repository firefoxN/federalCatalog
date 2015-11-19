<?php

namespace Bundles\Product\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

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
        //@TODO добавить пагинацию

        $vendors = $this->getDoctrine()->getRepository('ProductModelBundle:Vendor')->findAll();

        return array(
            'vendors' => $vendors,
        );
    }

    /**
     * Show a vendor
     *
     * @param string $slug
     *
     * @Route("/vendors/{slug}")
     * @Template()
     *
     * @throws NotFoundHttpException
     * @return array
     */
    public function showAction($slug)
    {
        //@TODO Добавить изображения к поставщику

        $vendor = $this->getDoctrine()->getRepository('ProductModelBundle:Vendor')->findOneBy(
            [
                'slug' => $slug,
            ]
        );

        if (null === $vendor) {
            throw $this->createNotFoundException('Vendor was not found');
        }

        return array(
            'vendor' => $vendor,
        );
    }
}
