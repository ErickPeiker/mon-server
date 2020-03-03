<?php

namespace App\Repository;

use App\Entity\EquipmentType;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class EquipmentTypeRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return EquipmentType::class;
    }
}
