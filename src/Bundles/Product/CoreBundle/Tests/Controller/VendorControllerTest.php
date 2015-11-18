<?php

namespace Bundles\Product\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class VendorControllerTest
 *
 * @package Bundles\Product\CoreBundle\Tests\Controller
 */
class VendorControllerTest extends WebTestCase
{
    /**
     * Tests vendors index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/vendors');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $this->assertCount(3, $crawler->filter('h3'), 'There should be 3 displayed vendors');
    }
}
