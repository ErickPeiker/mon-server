<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\User;

class UserRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $company = (new CompanyRepositoryTest())->getFlushedMockObject();

        $user = (new User())
            ->setEmail($faker->email)
            ->setPassword('$2y$13$tuXyoWFQD.zG0qkppqYFyeDe.q9DMjTOzL/KQUcaG9PTn4uNn/gZ.') // hash for password: '123123'
            ->setRoles(['ROLE_ADMIN'])
            ->setPhysicalPerson((new PhysicalPersonRepositoryTest())->getMockObject())
            ->addGroup((new GroupRepositoryTest())->getFlushedMockObject())
            ->setCompany($company)
            ->addCompany($company);

        return $user;
    }
}
