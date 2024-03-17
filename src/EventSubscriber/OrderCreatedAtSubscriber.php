<?php

namespace App\EventSubscriber;
use App\Entity\OrderDetail;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;


class OrderCreatedAtSubscriber implements EventSubscriberInterface
{
  public function getSubscribedEvents()
  {
    return [
      Events::prePersist
    ];
  }

  public function prePersist(PrePersistEventArgs $args):Void
  {
    $object = $args->getObject();
    if(!$object instanceof OrderDetail) {
      return;
    }

    $object->setCreatedAt(new \DateTimeImmutable());
  }
}