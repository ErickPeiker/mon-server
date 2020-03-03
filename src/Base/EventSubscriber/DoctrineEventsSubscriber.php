<?php

namespace App\Base\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class DoctrineEventsSubscriber implements EventSubscriber
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $repository = $args->getEntityManager()->getRepository(get_class($entity));

        if (method_exists($repository, 'prePersist')) {
            $repository->prePersist($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $repository = $em->getRepository(get_class($entity));

        if (method_exists($repository, 'preUpdate')) {
            $repository->preUpdate($entity);
            $meta = $em->getClassMetadata(get_class($entity));
            $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $repository = $args->getEntityManager()->getRepository(get_class($entity));

        if (method_exists($repository, 'preRemove')) {
            $repository->preRemove($entity);
        }
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist => 'prePersist',
            Events::preUpdate => 'preUpdate',
            Events::preRemove => 'preRemove',
        ];
    }
}
