<?php

namespace Bundles\Category\CoreBundle\Tests\Controller;

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

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successfull');

        /**
         * @var NestedTreeRepository $repository
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

}
