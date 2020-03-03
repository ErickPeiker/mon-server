<?php

namespace App\Repository;

use App\Entity\Country;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class CountryRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Country::class;
    }
}
