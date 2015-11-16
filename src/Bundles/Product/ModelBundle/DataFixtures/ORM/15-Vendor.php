<?php
namespace Bundles\Product\ModelBundle\DataFixtures\ORM;

use Bundles\Product\ModelBundle\Entity\Vendor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

/**
 * Class Vendor loads fixtures for vendor
 *
 * @package Bundles\Product\ModelBundle\DataFixtures\ORM
 */
class Vendors extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = FakerFactory::create('ru_RU');

        for ($i=0; $i<3; $i++) {
            $vendor = new Vendor();
            $vendor->setName($faker->company);
            $vendor->setDescription($faker->realText(100));

            $manager->persist($vendor);
        }

        $manager->flush();
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
}