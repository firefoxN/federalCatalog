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
}
