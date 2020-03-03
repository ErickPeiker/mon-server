<?php

namespace App\Repository;

use App\Entity\Rule;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class RuleRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Rule::class;
    }
}
