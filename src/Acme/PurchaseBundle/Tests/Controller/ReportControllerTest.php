<?php

namespace Ra\Bundle\PurchaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportControllerTest extends WebTestCase
{
    public function testTransfer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/transfer');
    }

    public function testPurchase()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/purchase');
    }

    public function testExpire()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/expire');
    }

}
