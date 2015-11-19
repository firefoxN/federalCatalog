<?php
/**
 * Created by PhpStorm.
 * User: natali
 * Date: 19.11.15
 * Time: 18:28
 */

namespace Bundles\Category\ModelBundle\DataFixtures\ORM;


use Bundles\Category\ModelBundle\Entity\ClassificationProduct;
use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Bundles\Product\ModelBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

/**
 * Class CatalogProductRel
 */
class CatalogProductRel extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = FakerFactory::create('ru_RU');

        //all products of first vendor
        for ($j = 0; $j < 10; $j++) {
            $classificationProduct1 = new ClassificationProduct();
            /**
             * @var CustomCatalog $customCategory1
             */
            $customCategory1 = $this->getReference('fakerdish');
            $fullClass = get_class($customCategory1);
            $nmsps = stristr($fullClass, 'bundles');
            /**
             * @var Product $product
             */
            $product = $this->getReference('product-1-'.$j);
            $classificationProduct1->setNmsps($nmsps);
            $classificationProduct1->setClassification($customCategory1);
            $classificationProduct1->setProduct($product);
            $manager->persist($classificationProduct1);
        }

        //all products of second vendor
        for ($j = 0; $j < 10; $j++) {
            $classificationProduct2 = new ClassificationProduct();
            /**
             * @var CustomCatalog $customCategory2
             */
            $customCategory2 = $this->getReference('smallcarrots');
            $fullClass = get_class($customCategory2);
            $nmsps = stristr($fullClass, 'bundles');
            /**
             * @var Product $product
             */
            $product = $this->getReference('product-2-'.$j);
            $classificationProduct2->setNmsps($nmsps);
            $classificationProduct2->setClassification($customCategory2);
            $classificationProduct2->setProduct($product);
            $manager->persist($classificationProduct2);
        }

        //all products of third vendor
        for ($j = 0; $j < 10; $j++) {
            $classificationProduct3 = new ClassificationProduct();
            /**
             * @var CustomCatalog $customCategory3
             */
            $customCategory3 = $this->getReference('faker-Lvl3-0');
            $fullClass = get_class($customCategory3);
            $nmsps = stristr($fullClass, 'bundles');
            /**
             * @var Product $product
             */
            $product = $this->getReference('product-3-'.$j);
            $classificationProduct3->setNmsps($nmsps);
            $classificationProduct3->setClassification($customCategory3);
            $classificationProduct3->setProduct($product);
            $manager->persist($classificationProduct3);
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
        return 25;
    }
}