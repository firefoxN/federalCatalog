<?php
namespace Bundles\Category\ModelBundle\DataFixtures\ORM;


use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

/**
 * Class CustomCatalogFixtures
 *
 * @package Bundles\Category\ModelBundle\DataFixtures\ORM
 */
class CustomCatalogFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = FakerFactory::create('ru_RU');

        $food = new CustomCatalog();
        $food->setTitle('Food');
        $manager->persist($food);

        $fruits = new CustomCatalog();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);
        $manager->persist($fruits);

        $vegetables = new CustomCatalog();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);
        $manager->persist($vegetables);

        $carrots = new CustomCatalog();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);
        $manager->persist($carrots);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }
}