<?php

namespace App\Repository;

use App\Entity\Action;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class ActionRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Action::class;
    }
}
