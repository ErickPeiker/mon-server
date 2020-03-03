<?php

namespace App\Repository;

use App\Entity\ConfigurationValue;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class ConfigurationValueRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return ConfigurationValue::class;
    }
}
