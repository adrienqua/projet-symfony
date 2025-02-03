<?php

namespace App\Tests\Entity;

use App\Entity\Offer;
use App\Entity\Renter;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class OfferTest extends TestCase
{
    public function testOfferSettersAndGetters(): void
    {
        $renter = new Renter();
        $renter->setUsername('adrienqua');
        $renter->setEmail('adrien.quacchia@gmail.com');
        $renter->setPlainPassword('adrien1234');
        $renter->setFirstName('Adrien');
        $renter->setLastName('Quacchia');
        $renter->setBirthDate(new \DateTimeImmutable('1997-02-25'));

        $category = new Category();
        $category->setName('Test category');
        $category->setDescription('Test description');



        $offer = new Offer();
        $offer->setTitle('Test offer');
        $offer->setDescription('Test description');
        $offer->setPrice(99.99);
        $offer->setCategory($category);
        $offer->setRenter($renter);

        $this->assertEquals('Test offer', $offer->getTitle());
        $this->assertEquals('Test description', $offer->getDescription());
        $this->assertEquals(99.99, $offer->getPrice());

    }
}