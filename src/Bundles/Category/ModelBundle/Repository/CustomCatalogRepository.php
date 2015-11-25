<?php

namespace Bundles\Category\ModelBundle\Repository;

use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Doctrine\ORM\Query;

/**
 * CustomCatalogRepository
 */
class CustomCatalogRepository extends NestedTreeRepository
{

    /**
     * Get the children tree query builder for node
     *
     * @param object       $node Catalog Item
     * @param null|integer $lvl  Level, within have to be the sample
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getTreeForItemUpLvlExceptSelfQueryBuilder($node, $lvl = null)
    {
        $qb = $this->getChildrenQueryBuilder($node, false, 'lft');

        if (null !== $lvl) {
            $qb->andWhere('node.lvl < '.$lvl);
        }

        return $qb;
    }

    /**
     * Get the children tree query for node
     *
     * @param object       $node Catalog Item
     * @param null|integer $lvl  Level, within have to be the sample
     *
     * @return Query
     */
    public function getTreeForItemUpLvlExceptSelfQuery($node, $lvl = null)
    {
        return $this->getTreeForItemUpLvlExceptSelfQueryBuilder($node, $lvl)->getQuery();
    }

    /**
     * Get the children tree array of objects for node
     *
     * @param object       $node Catalog Item
     * @param null|integer $lvl  Level, within have to be the sample
     *
     * @return array
     */
    public function getTreeForItemUpLvlExceptSelf($node, $lvl = null)
    {
        return $this->getTreeForItemUpLvlExceptSelfQuery($node, $lvl)->getResult();
    }

    /**
     * return the first custom catalog
     *
     * @return CustomCatalog
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findFirst()
    {
        $em = $this->getEntityManager();

        $query = $em
            ->createQueryBuilder()
            ->select('node')
            ->from('CategoryModelBundle:CustomCatalog', 'node')
            ->orderBy('node.id', 'ASC')
            ->setMaxResults(1)
        ;


        return $query->getQuery()->getSingleResult();
    }

    /**
     * Get our root nodes, pseudo is because we have single root node which we mast no change
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPseudoRootNodesQueryBuilder()
    {
        $meta = $this->getClassMetadata();
        $config = $this->listener->getConfiguration($this->_em, $meta->name);
        $qb = $this->getQueryBuilder();
        $qb
            ->select('node')
            ->from($config['useObjectClass'], 'node')
            ->where('node.lvl = 1')
            ->orderBy('node.'.$config['left'], 'ASC')
        ;

        return $qb;
    }

    /**
     * Get our root nodes, pseudo is because we have single root node which we mast no change
     *
     * @return Query
     */
    public function getPseudoRootNodesQuery()
    {
        return $this->getPseudoRootNodesQueryBuilder()->getQuery();
    }

    /**
     * Get our root nodes, pseudo is because we have single root node which we mast no change
     *
     * @return array
     */
    public function getPseudoRootNodes()
    {
        return $this->getPseudoRootNodesQuery()->getResult();
    }

    /**
     * Get custom category's lives (we have to add products only into lives)
     *
     * @param array $arrValues Array with ids which are parent
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAvailableForAddingCategoriesQueryBuilder($arrValues)
    {
        $meta = $this->getClassMetadata();
        $config = $this->listener->getConfiguration($this->_em, $meta->name);

        $qb = $this->getQueryBuilder();
        $qb
            ->select('node')
            ->from($config['useObjectClass'], 'node')
            ->where($qb->expr()->notIn('node.id', $arrValues))
        ;

        return $qb;
    }

    /**
     * Get custom category's lives (we have to add products only into lives)
     *
     * @param array $arrValues Array with ids which are parent
     *
     * @return Query
     */
    public function getAvailableForAddingCategoriesQuery($arrValues)
    {
        return $this->getAvailableForAddingCategoriesQueryBuilder($arrValues)->getQuery();
    }

    /**
     * Get custom category's lives (we have to add products only into lives)
     *
     * @param array $arrValues Array with ids which are parent
     *
     * @return array of object
     */
    public function getAvailableForAddingCategories($arrValues)
    {
        return $this->getAvailableForAddingCategoriesQuery($arrValues)->getResult();
    }
}
