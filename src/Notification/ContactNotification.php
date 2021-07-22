<?php
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{

    private $mailer;

    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)

    {
        $this->mailer = $mailer; 
        $this->renderer= $twig; 
    }


    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Contact'))
            ->setFrom('artistemail@sfr.fr')
            ->setTo('artistemail@sfr.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/contact.html.twig',
        [
            'contact'=> $contact
            ]), 'text/html');

            $this->mailer->send($message);
    }
}