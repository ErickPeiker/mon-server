<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Dashboard;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class DashboardRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Dashboard::class;
    }

    public function prePersist($entity)
    {
        // @TODO pegar a empresa do usuário
        if (!$entity->getCompany() && ($user = $this->getUser())) {
            $entity->setCompany($user->getCompany());
        }
    }

    public function defaultFilters($queryWorker)
    {
        if (($user = $this->getUser()) && $this->getManager()->getFilters()->isEnabled('company')) {
            $queryWorker->andWhere('company.id', 'equals', $user->getCompany()->getId());
        }
    }
}
