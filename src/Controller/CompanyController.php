<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\Company;

class CompanyController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(Company::class);
    }
}
