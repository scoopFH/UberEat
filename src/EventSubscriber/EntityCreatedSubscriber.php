<?php

namespace App\EventSubscriber;

use App\Entity\User;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
  }
}