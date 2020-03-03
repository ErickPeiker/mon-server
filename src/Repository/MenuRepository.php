<?php

namespace App\Repository;

use App\Entity\Menu;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class MenuRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Menu::class;
    }
}
