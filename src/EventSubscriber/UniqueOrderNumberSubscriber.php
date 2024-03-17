<?php

namespace App\EventSubscriber;
use App\Entity\OrderDetail;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Faker\Factory;

class UniqueOrderNumberSubscriber implements EventSubscriberInterface
{
  public function __construct(private EntityManagerInterface $em){}

  public function prePersist(PrePersistEventArgs $args):void
  {
    $object = $args->getObject();
    if($object instanceof OrderDetail && empty($object->getOrderNumber())) {
      $object->setOrderNumber($this->generateUniqueOrderNumber());
    }
  }

  private function generateUniqueOrderNumber():string 
  {
    $faker = Factory::create();
    $unique = false;
    $orderNumber = "";

    while(!$unique){
      $orderNumber = $faker->randomNumber(9, true);
      $existing = $this->em->getRepository(OrderDetail::class)->findOneBy(['orderNumber'=> $orderNumber]);
      if(!$existing) {
        $unique = true;
      }
    }
    return $orderNumber;
  }
  public function getSubscribedEvents()
  {
    return [
      Events::prePersist
    ];
  }
  
}