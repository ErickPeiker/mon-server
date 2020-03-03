<?php

namespace App\Repository;

use App\Entity\Criteria;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class CriteriaRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Criteria::class;
    }
}
