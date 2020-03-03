<?php

namespace App\Repository;

use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;
use App\Entity\Incident;

class IncidentRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Incident::class;
    }

    public function defaultFilters($queryWorker)
    {
        if (($user = $this->getUser()) && $this->getManager()->getFilters()->isEnabled('company')) {
            $queryWorker->andWhere('company.id', 'equals', $user->getCompany()->getId());
        }
    }
}
