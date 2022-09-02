<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception;

class Mailer_resetPassword{
/** 
    *@var MailerInterface;
    */
    private $mailer2;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $token)
    {
        $email = (new TemplatedEmail())
            ->from('resetPassword@example.com')
            ->to(new Address($email))
            ->subject("Réinitialisation du mot de passe")
            ->htmlTemplate(template: 'emails/reset.html.twig')
            ->context([
                'token' => $token,
            ]);
            
            $this->mailer->send($email);
    }
}