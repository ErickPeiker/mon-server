<?php

namespace App\Tests\Controller;

use App\Tests\Repository\CompanyRepositoryTest;
use App\Base\Test\Controller\CrudControllerTest;

class CompanyControllerTest extends CrudControllerTest
{
    public function getRepositoryTest()
    {
        return (new CompanyRepositoryTest());
    }

    public function getRoute()
    {
        return '/company';
    }
}
