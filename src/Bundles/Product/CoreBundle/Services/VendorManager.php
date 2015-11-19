<?php

namespace Bundles\Product\CoreBundle\Services;

use Bundles\Product\ModelBundle\Entity\Vendor;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class VendorManager
 */
class VendorManager
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
     * Find vendor by slug
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return \Bundles\Product\ModelBundle\Entity\Vendor
     */
    public function findBySlug($slug)
    {
        $vendor = $this->em->getRepository('ProductModelBundle:Vendor')->findOneBy(
            [
                'slug' => $slug,
            ]
        );

        if (null === $vendor) {
            throw new NotFoundHttpException('Vendor was not found');
        }

        return $vendor;
    }

    /**
     * Find products by vendor
     *
     * @param Vendor $vendor
     *
     * @return array|\Bundles\Product\ModelBundle\Entity\Product[]
     */
    public function findProducts(Vendor $vendor)
    {
        $products = $this->em->getRepository('ProductModelBundle:Product')->findBy(
            [
                'vendor' => $vendor,
            ]
        );

        return $products;
    }
}