<?php

namespace App\Repository;

use App\Entity\Route;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class RouteRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Route::class;
    }
}
