<?php

namespace App\Repository;

use App\Entity\ItemType;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class ItemTypeRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return ItemType::class;
    }
}
