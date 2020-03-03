<?php

namespace App\Repository;

use App\Entity\PhysicalPerson;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class PhysicalPersonRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return PhysicalPerson::class;
    }
}
