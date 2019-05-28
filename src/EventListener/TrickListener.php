<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 10/04/19
 * Time: 16:31
 */

namespace App\EventListener;

// for Doctrine < 2.4: use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Trick;

class TrickListener
{
    private $em;

    public function __construct(TrickRepository $em)
    {
        $this->em = $em;
    }

    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();
        // only act on some "Product" entity
        if (!$entity instanceof Trick) {
            $entity = new Trick();
            return;
        }

        $entityManager = $args->getObjectManager();
        $entity->setSlug($entity->getName());
        $entity->setDateAdd(new \DateTime());
        $entity->setPosition($this->em->getHightPosition() + 1);


        // ... do something with the Product
    }

    public function preUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();
        // only act on some "Product" entity
        if (!$entity instanceof Trick) {
            $entity = new Trick();
            return;
        }

        $entityManager = $args->getObjectManager();
        $entity->setSlug($entity->getName());


        // ... do something with the Product
    }
}