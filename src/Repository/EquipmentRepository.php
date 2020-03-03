<?php

namespace App\Repository;

use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;
use App\Entity\Equipment;

class EquipmentRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Equipment::class;
    }

    public function defaultFilters($queryWorker)
    {
        if (($user = $this->getUser()) && $this->getManager()->getFilters()->isEnabled('company')) {
            $queryWorker->orWhere('company.id', 'equals', $user->getCompany()->getId())
                ->orWhere('company.company.id', 'equals', $user->getCompany()->getId());
        }
    }
}
