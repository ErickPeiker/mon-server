<?php

namespace App\Repository;

use App\Entity\LegalPerson;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class LegalPersonRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return LegalPerson::class;
    }
}
