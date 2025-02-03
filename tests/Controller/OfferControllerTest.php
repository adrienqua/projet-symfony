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

        $this->assertGreaterThan(
            0,
            $crawler->filter('h1')->count(),
            'La page doit avoir une balise h1.'
        );

        $this->assertStringContainsString(
            'Toutes les annonces', 
            $crawler->filter('h1')->text(),
            'La balise h1 doit afficher "Toutes les annonces".'
        );

        $this->assertResponseIsSuccessful();
    }
}