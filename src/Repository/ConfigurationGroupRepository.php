<?php

namespace App\Repository;

use App\Entity\ConfigurationGroup;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class ConfigurationGroupRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return ConfigurationGroup::class;
    }
}
