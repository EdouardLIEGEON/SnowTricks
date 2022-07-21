<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception;

class Mailer{
/** 
    *@var MailerInterface;
    */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $token)
    {
        $email = (new TemplatedEmail())
            ->from('registration@example.com')
            ->to(new Address($email))
            ->subject("Confirmation d'inscription au site Snowtricks")
            ->htmlTemplate(template: 'emails/registration.html.twig')
            ->context([
                'token' => $token,
            ]);
            
            $this->mailer->send($email);
    }
}