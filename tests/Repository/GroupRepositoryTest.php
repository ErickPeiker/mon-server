<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Group;

class GroupRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $group = (new Group())
            ->setName($faker->name)
            ->setCompany((new CompanyRepositoryTest)->getFlushedMockObject());

        return $group;
    }
}
