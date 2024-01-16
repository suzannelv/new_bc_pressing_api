<?php
namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Newsletter;
use App\Event\NewsletterSubscribedEvent;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;

class NewsletterSubscriber implements EventSubscriberInterface
{
  
    public function __construct(private MailerInterface $mailer, private string $adminEmail){

    }

    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE]
        ];
    }

    public function sendMail(ViewEvent $event):void{
        $email = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$email instanceof Newsletter || Request::METHOD_POST !== $method) {
            return;
        }

        $message = (new TemplatedEmail())
        ->from($this->adminEmail)
        ->to($email->getEmail())
        ->subject('Confirmation d\'inscription')
        ->htmlTemplate('subscriber/confirm_email.html.twig');
    
        $this->mailer->send($message);
    }

    // public function getSubscribedEvents(): array
    // {
    //     return [
    //         Events::prePersist
    //     ];
    // }

    // public function prePersist(PrePersistEventArgs $args): void
    // {
    //    $entity = $args->getObject();
    //    if(!$entity instanceof Newsletter){
    //     return;
    //    }

    // }
}
