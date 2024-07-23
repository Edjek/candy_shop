<?php

namespace App\Controller\Front;

use App\DTO\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact', name: 'front_contact_')]
class ContactControler extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ajouter une propriété service dans la class

            // avoir une liste deroulante
                // 'directeur' => 'cto@company.com'
                // 'comptabilité' => 'compta@company.com'
                // 'support' => 'support@company.com'

            $email = (new Email())
            ->from($contact->getEmail())
            ->to($contact->getService())
            ->subject('Un nouvel Email envoyé par le formualire de contact')
            ->text($contact->getMessage())
            ->html($contact->getMessage());

        $mailer->send($email);
        }

        return $this->render(
            'front/contact/index.html.twig',
            [
                'contact_form' => $form
            ]
        );
    }
}
