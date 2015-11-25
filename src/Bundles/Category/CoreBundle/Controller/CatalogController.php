<?php

namespace Bundles\Category\CoreBundle\Controller;

use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Bundles\Category\ModelBundle\Repository\ClassificationProductRepository;
use Bundles\Category\ModelBundle\Repository\CustomCatalogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class CatalogController
 *
 * @package Bundles\Category\CoreBundle\Controller
 */
class CatalogController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $arrData = [];
        $roots = $this->getCustomClassificationManager()->getRootNodes();

        foreach ($roots as $root) {
            /**
             * @var CustomCatalog $root
             */
            $arrData[$root->getId()] = $this->getCustomClassificationManager()
                ->getArrayTreeForItemUpLvlExceptSelf($root, 4);
        }

        return array(
            'roots'        => $roots,
            'subMenuDatas' => $arrData,
        );
    }

    /**
     * Show custom category page
     *
     * @param Request $request
     * @param string  $slug
     *
     * @Route("/{slug}")
     * @Template()
     *
     * @return array
     */
    public function showCustomCategoryAction(Request $request, $slug)
    {
        //@TODO Добавить картинку к категории

        $leaves = false;
        $customClassificationManager = $this->getCustomClassificationManager();
        $classification = $customClassificationManager->findBySlug($slug);

        $childQntt = $customClassificationManager->getChildCount($classification);
        if ($childQntt > 0) {
            $categories = $customClassificationManager->getDirectChildrenQuery($classification);

            $pagination = $this->getPagination($request, $categories);
        } else {
            $classificationProductManager = $this->getClassificationProductManager();
            $nmsps = 'Bundles\Category\ModelBundle\Entity\CustomCatalog';
            $products = $classificationProductManager->getProductList($nmsps, $classification->getId());

            $pagination = $this->getPagination($request, $products);
            $leaves = true;
        }


        return array(
            'classification' => $classification,
            'pagination'     => $pagination,
            'leaves'         => $leaves,
        );
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

    /**
     * @param Request             $request
     * @param \Doctrine\ORM\Query $query
     * @param int                 $limit
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    private function getPagination(Request $request, $query, $limit = 9)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            $limit/*limit per page*/
        );

        return $pagination;
    }
}
