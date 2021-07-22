<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
      *@Route("/pages/contact", name="contact") 
       */  

      public function contact(Request $request,ContactNotification $mailer): Response
      {


       $contact = new Contact();
       $formContact=$this->createForm(ContactType::class,$contact);
       $formContact->handleRequest($request);
       if ($formContact->isSubmitted() && $formContact->isValid()) {
           
           $mailer->notify($contact);
           
           $this->addFlash('success', "Email envoyé avec succès");
           return $this->redirectToRoute('contact');
         }
     
       return $this->render('/pages/contact.html.twig',[
           'current_menu' => 'contact',
           'formContact' => $formContact->createView()
       ]);
      }
}
