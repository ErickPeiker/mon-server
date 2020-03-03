<?php

namespace App\Repository;

use App\Entity\City;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class CityRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return City::class;
    }
}
