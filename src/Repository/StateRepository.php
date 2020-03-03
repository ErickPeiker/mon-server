<?php

namespace App\Repository;

use App\Entity\State;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class StateRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return State::class;
    }
}
