<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Route;

class RouteController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Route::class);
    }
}
