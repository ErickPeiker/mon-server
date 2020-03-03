<?php

namespace App\Repository;

use App\Entity\Person;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class PersonRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Person::class;
    }
}
