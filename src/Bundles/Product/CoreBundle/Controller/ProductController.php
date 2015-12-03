<?php

namespace Bundles\Product\CoreBundle\Controller;

use Bundles\Category\ModelBundle\Entity\ClassificationProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 *
 * @Route("/products")
 */
class ProductController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return array(
        );
    }

    /**
     * Show product page
     *
     * @param Request $request
     * @param string  $slug
     *
     * @Route("/{slug}")
     * @Template()
     *
     * @return array
     */
    public function showProductAction(Request $request, $slug)
    {
        $product = $this->getProductManager()->findBySlug($slug);

        $ccm = $this->getCustomClassificationManager();
        $nmsps = $ccm->getEntityClassName();

        $cpm = $this->getClassificationProductManager();
        /**
         * @var ClassificationProduct $classificationProduct
         */
        $classificationProduct = $cpm->getCategoryByProduct($nmsps, $product)->getResult();
        $categoryId = $classificationProduct[0]->getClassification();


        $classification = $ccm->findById($categoryId);

        return array(
            'product' => $product,
            'classification' => $classification,
        );
    }

    /**
     * @return \Bundles\Product\CoreBundle\Services\ProductManager
     */
    private function getProductManager()
    {
        return $this->get('product_manager');
    }

    /**
     * @return \Bundles\Category\CoreBundle\Services\CustomClassificationManager
     */
    private function getCustomClassificationManager()
    {
        return $this->get('manager.custom_catalog');
    }

    /**
     * @return \Bundles\Category\CoreBundle\Services\ClassificationProductManager
     */
    private function getClassificationProductManager()
    {
        return $this->get('manager.classification_product');
    }
}
