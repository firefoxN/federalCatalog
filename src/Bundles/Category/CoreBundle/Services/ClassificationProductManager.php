<?php
/**
 * Created by PhpStorm.
 * User: natali
 * Date: 22.11.15
 * Time: 17:09
 */

namespace Bundles\Category\CoreBundle\Services;


use Bundles\Category\ModelBundle\Repository\ClassificationProductRepository;
use Doctrine\ORM\EntityManager;

class ClassificationProductManager
{
    private $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get product list according strategy
     *
     * @param string  $nmsps
     * @param integer $categoryId
     *
     * @return array like
     * [0] => Array(
     *      [id] => 21
     *      [classification] => 14
     *      [nmsps] => Bundles\Category\ModelBundle\Entity\CustomCatalog
     *      [product] => Array (
     *          [createdAt] => DateTime Object (
     *              [date] => 2015-11-19 19:33:08.000000
     *              [timezone_type] => 3
     *              [timezone] => Europe/Moscow
     *          )
     *          [updatedAt] => DateTime Object (
     *              [date] => 2015-11-19 19:33:08.000000
     *              [timezone_type] => 3
     *              [timezone] => Europe/Moscow
     *          )
     *          [id] => 21
     *          [title] => Velit soluta fugit.
     *          [slug] => velit-soluta-fugit
     *          [description] => ...
     *          [price] => 342.52
     *      )
     * )
     */
    public function getArrayProductList($nmsps, $categoryId)
    {
        $repository = $this->getClassificationProductRepository();
        $query = $repository->getAllProductsInGroupByIdQuery($nmsps, $categoryId);

        return $query->getArrayResult();
    }

    /**
     * Get product list according strategy
     *
     * @param string  $nmsps
     * @param integer $categoryId
     *
     * @return \Doctrine\ORM\Query
     */
    public function getProductList($nmsps, $categoryId)
    {
        $repository = $this->getClassificationProductRepository();
        $query = $repository->getAllProductsInGroupByIdQuery($nmsps, $categoryId);

        return $query;
    }

    /**
     * @return ClassificationProductRepository
     */
    private function getClassificationProductRepository()
    {
        /**
         * @var ClassificationProductRepository $repository
         */
        $repository = $this->em->getRepository('CategoryModelBundle:ClassificationProduct');

        return $repository;
    }
}