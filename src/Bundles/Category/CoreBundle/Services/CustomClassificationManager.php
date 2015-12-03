<?php

namespace Bundles\Category\CoreBundle\Services;

use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Bundles\Category\ModelBundle\Repository\CustomCatalogRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CustomClassificationManager
 */
class CustomClassificationManager implements ClassificationInterface
{
    const ENTITY_CLASS_NAME = 'Bundles\Category\ModelBundle\Entity\CustomCatalog';

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
     * Find custom category by slug
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return \Bundles\Category\ModelBundle\Entity\CustomCatalog
     */
    public function findBySlug($slug)
    {
        $customCategory = $this->getCustomCatalogRepository()->findOneBy(
            [
                'slug' => $slug,
            ]
        );

        if (null === $customCategory) {
            throw new NotFoundHttpException('Category was not found.');
        }

        return $customCategory;
    }

    /**
     * @param integer $id
     *
     * @return null|object
     */
    public function findById($id)
    {
        $customCategory = $this->getCustomCatalogRepository()->find($id);

        if (null === $customCategory) {
            throw new NotFoundHttpException('Category was not found.');
        }

        return $customCategory;
    }

    /**
     * Get all direct children for current node
     * If there are no children - return empty array
     *
     * @param CustomCatalog $node
     *
     * @return array
     */
    public function getDirectChildrenArray(CustomCatalog $node)
    {

        $children = $this->getCustomCatalogRepository()->getChildren($node, true, 'lft', 'ASC');

        return $children;
    }

    /**
     * Get all direct children for current node
     *
     * @param CustomCatalog $node
     *
     * @return \Doctrine\ORM\Query
     */
    public function getDirectChildrenQuery(CustomCatalog $node)
    {
        $children = $this->getCustomCatalogRepository()->getChildrenQuery($node, true, 'lft', 'ASC');

        return $children;
    }

    /**
     * Get quantity of dirtect children
     *
     * @param CustomCatalog $node
     *
     * @return int
     */
    public function getChildCount(CustomCatalog $node)
    {
        return $this->getCustomCatalogRepository()->childCount($node, true);
    }

    /**
     * Get only root nodes
     *
     * @return array of root objects
     */
    public function getRootNodes()
    {
        $roots = $this->getCustomCatalogRepository()->getPseudoRootNodes();

        return $roots;
    }

    /**
     * Get the children tree array for node
     *
     * @param CustomCatalog $node
     * @param integer       $number
     *
     * @return array
     */
    public function getArrayTreeForItemUpLvlExceptSelf(CustomCatalog $node, $number)
    {
        $arrayTree = $this->getCustomCatalogRepository()->getTreeForItemUpLvlExceptSelfQuery($node, $number)
            ->getArrayResult();

        return $arrayTree;
    }

    /**
     * Get class name
     *
     * @return string
     */
    public function getEntityClassName()
    {
        return self::ENTITY_CLASS_NAME;
    }

    /**
     * Get custom category's lives list (we have to add products only into lives)
     *
     * @return array
     */
    public function getListOfAvailableForAddingCategories()
    {
        $arrayLives = $this->getCustomCatalogRepository()->getAvailableForAddingCategoriesQuery()->getArrayResult();

        return $arrayLives;
    }

    /**
     * Get product list according strategy
     *
     * @return array
     */
    public function getProductList()
    {
        // TODO: Implement getProductList() method.
    }

    /**
     * @return CustomCatalogRepository
     */
    private function getCustomCatalogRepository()
    {
        /**
         * @var CustomCatalogRepository $repository
         */
        $repository = $this->em->getRepository('CategoryModelBundle:CustomCatalog');

        return $repository;
    }
}