<?php

namespace App\Repository;

use App\Entity\Group;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class GroupRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Group::class;
    }

    public function defaultFilters($queryWorker)
    {
        if (($user = $this->getUser()) && $this->getManager()->getFilters()->isEnabled('company')) {
            $queryWorker->andWhere('company.id', 'equals', $user->getCompany()->getId());
        }
    }
}
