<?php 

namespace App\EventSubscriber;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

class UserCreatedAtSubscriber implements EventSubscriberInterface
{
  public function getSubscribedEvents():array
  {
    return [
      Events::prePersist
    ];

  }

  public function prePersist(PrePersistEventArgs $args):void
  {
    $entity = $args->getObject();
    if(!$entity instanceof User){
      return ;
    }

    $entity->setCreatedAt(new \DateTimeImmutable());
  }
}