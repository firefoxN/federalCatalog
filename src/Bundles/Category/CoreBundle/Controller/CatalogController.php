<?php

namespace Bundles\Category\CoreBundle\Controller;

use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Bundles\Category\ModelBundle\Repository\CustomCatalogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        /**
         * @var CustomCatalogRepository $repository
         */
        $repository = $this->getDoctrine()->getRepository('CategoryModelBundle:CustomCatalog');
        $roots = $repository->getRootNodes();

        foreach ($roots as $root) {
            /**
             * @var CustomCatalog $root
             */
            $arrData[$root->getRoot()] = $repository->getTreeForItemUpLvlExceptSelfQuery($root, 3)->getArrayResult();
        }

        return array(
            'roots'        => $roots,
            'subMenuDatas' => $arrData,
        );
    }

}
