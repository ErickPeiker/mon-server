<?php

namespace App\Repository;

use App\Entity\Address;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class AddressRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Address::class;
    }
}
