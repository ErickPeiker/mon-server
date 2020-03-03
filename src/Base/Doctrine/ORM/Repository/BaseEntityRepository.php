<?php

namespace App\Base\Doctrine\ORM\Repository;

use App\Base\Doctrine\Common\Repository\BaseRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BaseEntityRepository extends ServiceEntityRepository
{
    use BaseRepository;

    protected $tokenStorage;

    public function __construct(ManagerRegistry $registry, TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        parent::__construct($registry, $this->getEntityClass());
    }

    public function getManager()
    {
        return parent::getEntityManager();
    }

    public function createQueryWorker()
    {
        $queryWorker = new QueryWorker($this);
        $this->defaultFilters($queryWorker);

        return $queryWorker;
    }

    public function getUser()
    {
        if (!$this->tokenStorage->getToken() || !is_object($user = $this->tokenStorage->getToken()->getUser())) {
            return;
        }

        return $user;
    }
}
