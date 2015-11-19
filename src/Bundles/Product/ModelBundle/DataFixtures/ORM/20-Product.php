<?php
namespace Bundles\Product\ModelBundle\DataFixtures\ORM;

use Bundles\Product\ModelBundle\Entity\Vendor;
use Bundles\Product\ModelBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

/**
 * Class Vendor loads fixtures for vendor
 *
 * @package Bundles\Product\ModelBundle\DataFixtures\ORM
 */
class Products extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = FakerFactory::create('ru_RU');

        for ($i = 1; $i < 4; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $product = new Product();
                $product->setTitle($faker->sentence(3));
                $product->setDescription($faker->realText(300));
                $product->setPrice($faker->randomFloat(2));
                /**
                 * @var Vendor $vendor
                 */
                $vendor = $this->getReference('vendor'.$i);
                $product->setVendor($vendor);

                $manager->persist($product);

                $this->addReference('product-'.$i.'-'.$j, $product);
            }
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
        return 20;
    }

    /**
     * @param ObjectManager $manager
     * @param               $name
     *
     * @return Vendor
     */
    private function getVendor(ObjectManager $manager, $name)
    {
        $vendor = $manager->getRepository('ProductModelBundle:Vendor')->findOneBy(['name'=>$name]);

        return $vendor;
    }
}