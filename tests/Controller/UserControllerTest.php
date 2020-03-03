<?php

namespace App\Tests\Controller;

use App\Tests\Repository\UserRepositoryTest;
use App\Base\Test\Controller\CrudControllerTest;

class UserControllerTest extends CrudControllerTest
{
    public function getRepositoryTest()
    {
        return (new UserRepositoryTest());
    }

    public function getRoute()
    {
        return '/user';
    }

    public function testCreate()
    {
    }
}
