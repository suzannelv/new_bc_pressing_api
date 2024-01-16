<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Event\NewsletterSubscribedEvent;
use App\Repository\NewsletterRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriberController extends AbstractController
{

    public function __construct(private EventDispatcherInterface $dispatcher, ){}

    #[Route('/subscribe', name: 'app_subscribe')]
    public function newsletterSubscribe (
        Request $request, 
        NewsletterRepository $newsletterRepository, 
        ObjectManager $manager
    ):Response
    {
        // revoir ici
        $email = $request->get('email');
        $existingEmail = $newsletterRepository->findOneBy(['email'=>$email]);
        if($existingEmail){
            return new Response('Cet email est déjà abonné.');
        }

        $newsletter= new Newsletter();
        $newsletter->setEmail($email);
        $manager->persist($newsletter);
        $manager->flush();
        
        $event=new NewsletterSubscribedEvent($newsletter);
        $this->dispatcher->dispatch($event, NewsletterSubscribedEvent::NAME);

        return new Response('Inscription réussie!');

    }
}
