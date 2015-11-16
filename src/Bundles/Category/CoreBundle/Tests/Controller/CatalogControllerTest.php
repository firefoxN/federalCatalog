<?php

namespace Bundles\Category\CoreBundle\Tests\Controller;

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
    }

}
