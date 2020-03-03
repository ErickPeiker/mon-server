<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Dashboard;

class DashboardRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $dashboard = (new Dashboard())
            ->setName($faker->name)
            ->setCompany((new CompanyRepositoryTest())->getMockObject());

        return $dashboard;
    }
}
