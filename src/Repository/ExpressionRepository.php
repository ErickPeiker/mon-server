<?php

namespace App\Repository;

use App\Entity\Expression;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class ExpressionRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Expression::class;
    }
}
