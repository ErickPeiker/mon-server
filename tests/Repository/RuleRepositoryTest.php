<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Rule;

class RuleRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $rule = (new Rule())
            ->setName($faker->name)
            ->setIsActive($faker->boolean)
            ->setCompany((new CompanyRepositoryTest())->getMockObject());

        return $rule;
    }
}
