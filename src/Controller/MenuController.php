<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Menu;

class MenuController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Menu::class);
    }
}
