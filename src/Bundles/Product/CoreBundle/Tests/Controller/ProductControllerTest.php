<?php

namespace Bundles\Product\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProductControllerTest
 *
 * @package Bundles\Product\CoreBundle\Tests\Controller
 */
class ProductControllerTest extends WebTestCase
{
    /**
     * tests product index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/products/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successfull');
    }

}
