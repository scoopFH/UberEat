<?php

namespace App\EventSubscriber;

use App\Entity\Commentary;
use App\Entity\User;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Order;

class EntityCreatedSubscriber implements EventSubscriber
{
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder)
  {
      $this->encoder = $encoder;
  }
  public function getSubscribedEvents()
  {
    return [
      Events::prePersist
    ];
  }

  public function prePersist(LifecycleEventArgs $args)
  {
    $object = $args->getObject();

    if ($object instanceof User) {
      $object->setPassword($this->encoder->encodePassword($object, $object->getPassword()));
    }

    if ($object instanceof Order) {
      $object->setOrderNumber(rand(0,2147483647));
      $object->setDeliveryDate(new DateTime('NOW'));
      $object->setState('in preparation');
    }

    if ($object instanceof Commentary) {
      $object->setSendDate(new DateTime('NOW'));
    }
  }
}