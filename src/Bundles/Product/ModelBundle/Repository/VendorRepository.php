<?php

namespace Bundles\Product\ModelBundle\Repository;

use Bundles\Product\ModelBundle\Entity\Vendor;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * VendorRepository
 */
class VendorRepository extends EntityRepository
{
    /**
     * Return array of latest vendor objects
     *
     * @param integer $num
     *
     * @return array
     */
    public function getLatest($num)
    {
        $qb = $this->getQueryBuilder()
            ->orderBy('v.createdAt', 'desc')
            ->setMaxResults($num);

        return $qb->getQuery()->getResult();
    }

    /**
     * Return first object Vendor
     *
     * @return Vendor
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findFirst()
    {
        $qb = $this->getQueryBuilder()
            ->orderBy('v.id', 'asc')
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ProductModelBundle:Vendor')
            ->createQueryBuilder('v');

        return $qb;
    }
}
