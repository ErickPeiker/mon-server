<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\IncidentType;

class IncidentTypeController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(IncidentType::class);
    }
}
