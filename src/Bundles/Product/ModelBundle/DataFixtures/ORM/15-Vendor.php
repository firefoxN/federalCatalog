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

        $vendor1 = new Vendor();
        $vendor1->setDescription($faker->realText(100));
        $faker->seed(1111);
        $vendor1->setName($faker->company);

        $manager->persist($vendor1);

        $vendor2 = new Vendor();
        $vendor2->setDescription($faker->realText(100));
        $faker->seed(1112);
        $vendor2->setName($faker->company);

        $manager->persist($vendor2);

        $vendor3 = new Vendor();
        $vendor3->setDescription($faker->realText(100));
        $faker->seed(1113);
        $vendor3->setName($faker->company);

        $manager->persist($vendor3);

        $manager->flush();

        $this->addReference('vendor1', $vendor1);
        $this->addReference('vendor2', $vendor2);
        $this->addReference('vendor3', $vendor3);
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