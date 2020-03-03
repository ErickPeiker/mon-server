<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\PhysicalPerson;

class PhysicalPersonRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $physicalPerson = (new PhysicalPerson())
            ->setName($faker->name)
            ->setCpf($faker->cpf(false))
            ->setRg($faker->rg(false))
            ->setBirthdate($faker->dateTime)
            ->setGender($faker->randomElement(['MASCULINO', 'FEMININO']))
            ->setMaritalStatus($faker->randomElement(['SOLTEIRO', 'CASADO']));

        if (!in_array('Address', $except)) {
            $physicalPerson->addAddress((new AddressRepositoryTest())->getMockObject(['Person']));
        }

        if (!in_array('Phone', $except)) {
            $physicalPerson->addPhone((new PhoneRepositoryTest())->getMockObject(['Person']));
        }

        return $physicalPerson;
    }
}
