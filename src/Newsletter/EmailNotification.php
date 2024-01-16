<?php

namespace App\Newsletter;
use App\Entity\Newsletter;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;



class EmailNotification
{
 public function __construct(
  private MailerInterface $mailer,
  private string $adminEmail
  ){

 }

 public function confirmSubscription(Newsletter $newsletterEmail):void
 {
  $email = (new TemplatedEmail())
    ->from($this->adminEmail)
    ->to($newsletterEmail->getEmail())
    ->subject('Confirmation d\'inscription')
    ->htmlTemplate('subscriber/confirm_email.html.twig');

  $this->mailer->send($email);

 }
}