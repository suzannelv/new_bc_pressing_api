<?php

namespace App\EventSubscriber;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Faker\Factory;

class UniqueEmpNumberSubscriber implements EventSubscriberInterface
{

  public function __construct(private EntityManagerInterface $em ){}

  public function prePersist(PrePersistEventArgs $args){
    $object = $args->getObject();

    if(!$object instanceof Employee){
      return;
    }

    $object->setEmpNumber($this->generateUniqueEmpNumber());
  }

  private function generateUniqueEmpNumber(): string
  {
      $faker = Factory::create();
      $unique = false;
      $empNumber = '';

      while (!$unique) {
          $empNumber = $faker->numerify('emp-######');
   
          $existing = $this->em->getRepository(Employee::class)->findOneBy(['empNumber' => $empNumber]);
          if (!$existing) {
              $unique = true;
          }
      }

      return $empNumber;
  }
  public function getSubscribedEvents()
  {
    return [
      Events::prePersist
    ];
  }
}