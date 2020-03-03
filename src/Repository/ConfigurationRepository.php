<?php

namespace App\Repository;

use App\Entity\Configuration;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class ConfigurationRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Configuration::class;
    }
}
