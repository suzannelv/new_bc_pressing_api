<?php

namespace App\EventSubscriber;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Faker\Factory;


class UniqueClientNumberSubscriber implements EventSubscriberInterface
{

  public function __construct(private EntityManagerInterface $em) {
    
  }

  public function prePersist(PrePersistEventArgs $args):void
  {
    $object = $args->getObject();
    if ($object instanceof Client && empty($object->getClientNumber())) {
      $object->setClientNumber($this->generateUniqueClientNumber());
    }


  }

  private function generateUniqueClientNumber(): string
  {
      $faker = Factory::create();
      $unique = false;
      $clientNumber = '';

      while (!$unique) {
          $clientNumber = $faker->numerify('clt-######');
   
          $existing = $this->em->getRepository(Client::class)->findOneBy(['clientNumber' => $clientNumber]);
          if (!$existing) {
              $unique = true;
          }
      }

      return $clientNumber;
  }

  public function getSubscribedEvents()
  {
      return [
        Events::prePersist
      ];
  }
}