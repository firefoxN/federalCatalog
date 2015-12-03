<?php
/**
 * Created by PhpStorm.
 * User: natali
 * Date: 03.12.15
 * Time: 16:55
 */

namespace Bundles\Product\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProductManager
 */
class ProductManager
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
     * Find product by slug
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return \Bundles\Product\ModelBundle\Entity\Vendor
     */
    public function findBySlug($slug)
    {
        $vendor = $this->em->getRepository('ProductModelBundle:Product')->findOneBy(
            [
                'slug' => $slug,
            ]
        );

        if (null === $vendor) {
            throw new NotFoundHttpException('Product was not found');
        }

        return $vendor;
    }
}