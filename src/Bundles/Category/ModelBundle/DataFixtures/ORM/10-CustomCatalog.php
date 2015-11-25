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

        $mainRoot = new CustomCatalog();
        $mainRoot->setTitle('== Корневой элемент ==');
        $manager->persist($mainRoot);

        $dishes = new CustomCatalog();
        $dishes->setTitle('Dishes');
        $dishes->setParent($mainRoot);
        $manager->persist($dishes);
        $this->addReference('dishes', $dishes);

        $fakerRoot = new CustomCatalog();
        $fakerRoot->setTitle($faker->sentence(2));
        $fakerRoot->setParent($mainRoot);
        $manager->persist($fakerRoot);

        for ($i=0; $i<3; $i++) {
            $fakerLvl2 = new CustomCatalog();
            $fakerLvl2->setTitle($faker->sentence(1));
            $fakerLvl2->setParent($fakerRoot);
            $manager->persist($fakerLvl2);
            for ($j=0; $j<3; $j++) {
                $fakerLvl3 = new CustomCatalog();
                $fakerLvl3->setTitle($faker->sentence(2));
                $fakerLvl3->setParent($fakerLvl2);
                $manager->persist($fakerLvl3);
            }
        }
        $this->addReference('faker-Lvl3-0', $fakerLvl3);

        $food = new CustomCatalog();
        $food->setTitle('Food');
        $food->setParent($mainRoot);
        $manager->persist($food);
        $this->addReference('food', $food);

        $fruits = new CustomCatalog();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);
        $manager->persist($fruits);
        $this->addReference('fruits', $fruits);

        $apple = new CustomCatalog();
        $apple->setTitle('Apple');
        $apple->setParent($fruits);
        $manager->persist($apple);
        $this->addReference('apple', $apple);

        $appleDelicious = new CustomCatalog();
        $appleDelicious->setTitle('Delicious');
        $appleDelicious->setParent($apple);
        $manager->persist($appleDelicious);

        $vegetables = new CustomCatalog();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);
        $manager->persist($vegetables);
        $this->addReference('vegetables', $vegetables);

        $carrots = new CustomCatalog();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);
        $manager->persist($carrots);
        $this->addReference('carrots', $carrots);

        $smallCarrots = new CustomCatalog();
        $smallCarrots->setTitle('Small carrots');
        $smallCarrots->setParent($carrots);
        $manager->persist($smallCarrots);
        $this->addReference('smallcarrots', $smallCarrots);

        $fakeDish = new CustomCatalog();
        $fakeDish->setTitle($faker->sentence(2));
        $fakeDish->setParent($dishes);
        $manager->persist($fakeDish);
        $this->addReference('fakerdish', $fakeDish);

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