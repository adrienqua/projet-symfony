<?php
namespace App\Controller;

use App\Form\SupportRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportController extends AbstractController
{
    #[Route('/support', name: 'app_support')]
    public function support(Request $request): Response
    {
        $form = $this->createForm(SupportRequestType::class);
        
        if ($request->isXmlHttpRequest()) {
            $selectedType = $request->request->get('type');
            
            $formData = ['requestType' => $selectedType];
            $form = $this->createForm(SupportRequestType::class, $formData);
            
            return $this->render('support/dynamic_fields.html.twig', [
                'supportForm' => $form->createView()
            ]);
        }
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $this->addFlash('success', 'Votre demande a été envoyée');
            return $this->redirectToRoute('app_support');
        }
    
        return $this->render('support/index.html.twig', [
            'supportForm' => $form->createView()
        ]);
    }
}