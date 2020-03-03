<?php

namespace App\Tests\Controller;

use App\Tests\Repository\GroupRepositoryTest;
use App\Base\Test\Controller\CrudControllerTest;

class GroupControllerTest extends CrudControllerTest
{
    public function getRepositoryTest()
    {
        return (new GroupRepositoryTest());
    }

    public function getRoute()
    {
        return '/group';
    }
}
