<?php

namespace Bundles\Category\ModelBundle\Repository;

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
     * Get the children tree array for node
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
}
