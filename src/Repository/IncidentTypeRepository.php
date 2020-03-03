<?php

namespace App\Repository;

use App\Entity\IncidentType;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class IncidentTypeRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return IncidentType::class;
    }
}
