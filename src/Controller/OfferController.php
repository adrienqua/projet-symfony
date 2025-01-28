<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class OfferController extends AbstractController
{
    #[Route('/annonces', name: 'app_offers_list')]
    public function offerList(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

        return $this->render('offer/offer_list.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/annonces/{id}', name: 'app_offer_details', methods: ['GET', 'POST'])]
    public function offerDetails(string $id, OfferRepository $offerRepository): Response
    {
        $offer = $offerRepository->find($id);

        return $this->render('offer/offer_details.html.twig', [
            'offer' => $offer,
        ]);
    }
}
