<?php

namespace Bundles\Category\CoreBundle\Tests\Controller;

use Bundles\Category\ModelBundle\Repository\ClassificationProductRepository;
use Bundles\Category\ModelBundle\Repository\CustomCatalogRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CatalogControllerTest
 *
 * @package Bundles\Category\CoreBundle\Tests\Controller
 */
class CatalogControllerTest extends WebTestCase
{
    /**
     * Test catalogs index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        /**
         * @var CustomCatalogRepository $repository
         */
        $repository = $client->getContainer()->get('doctrine')->getRepository('CategoryModelBundle:CustomCatalog');
        $roots = $repository->getRootNodes();
        $qnttRoots = count($roots);

        $this->assertCount(
            $qnttRoots,
            $crawler->filter('ul.nav.nav-pills li a'),
            'There should be '.$qnttRoots.' displayed root categories'
        );
    }

    /**
     * Test custom catalog page
     */
    public function testShow()
    {
        // @TODO добавить подсчёт количиства товаров в категории, учитывая пагинацию (9 товаров на страницу) в тестах
        // посчитать сколько на странице

        $client = static::createClient();

        /**
         * @var CustomCatalogRepository $repository
         */
        $repository = $client->getContainer()->get('doctrine')->getRepository('CategoryModelBundle:CustomCatalog');
        /**
         * @var ClassificationProductRepository $catProdRepository
         */
        $catProdRepository = $client->getContainer()->get('doctrine')->getRepository('CategoryModelBundle:ClassificationProduct');
        $category = $repository->findFirst();

        $crawler = $client->request('GET', '/'.$category->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        $qnttCat = $repository->childCount($category, true);
        $qntt = 0;
        if ($qnttCat > 0) {
            $qntt = $qnttCat;
        } else {
            $qntt = $catProdRepository->getQuantityRelativeProducts(
                'Bundles\Category\ModelBundle\Entity\CustomCatalog',
                $category->getId()
            );
        }

        if ($qntt > 9) {
            $qntt = 9;
        }

        $this->assertCount($qntt, $crawler->filter('h3'), 'There should be '.$qntt.' items');
    }

}
