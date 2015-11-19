<?php

namespace Bundles\Product\CoreBundle\Tests\Controller;

use Bundles\Product\ModelBundle\Entity\Vendor;
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

    /**
     * Tests for show action
     */
    public function testShow()
    {
        $client = static::createClient();

        /**
         * @var Vendor
         */
        $vendor = $client->getContainer()->get('doctrine')->getRepository('ProductModelBundle:Vendor')
                ->findFirst();

        $crawler = $client->request('GET', '/vendors/'.$vendor->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        $this->assertEquals($vendor->getName(), $crawler->filter('h1')->text(), 'Vendor name is invalid');
    }
}
