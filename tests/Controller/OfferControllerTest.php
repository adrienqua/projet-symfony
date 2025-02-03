<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class OfferControllerTest extends WebTestCase
{
    public function testOfferListPageLoads(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/annonces');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}