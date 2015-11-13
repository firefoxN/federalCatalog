<?php
namespace Bundles\Product\ModelBundle\DataFixtures\ORM;

use Bundles\Product\ModelBundle\Entity\Vendor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class Vendor loads fixtures for vendor
 *
 * @package Bundles\Product\ModelBundle\DataFixtures\ORM
 */
class Product extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * @param ObjectManager $manager
     * @param               $name
     *
     * @return Vendor
     */
    private function getVendor(ObjectManager $manager, $name)
    {
        return $manager->getRepository('ProductModelBundle:Vendor')->findOneBy(
            [
                'name' => $name,
            ]
        );
    }
}