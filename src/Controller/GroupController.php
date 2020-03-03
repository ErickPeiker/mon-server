<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Group;

class GroupController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Group::class);
    }
}
