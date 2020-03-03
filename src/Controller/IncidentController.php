<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Incident;

class IncidentController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Incident::class);
    }
}
