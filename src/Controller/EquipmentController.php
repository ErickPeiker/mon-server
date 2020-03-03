<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Equipment;

class EquipmentController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Equipment::class);
    }
}
