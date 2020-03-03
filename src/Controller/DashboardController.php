<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Dashboard;

class DashboardController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Dashboard::class);
    }
}
