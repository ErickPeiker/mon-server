<?php

namespace App\Repository;

use App\Entity\Phone;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class PhoneRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Phone::class;
    }
}
