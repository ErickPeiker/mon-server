<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\LegalPerson;

class LegalPersonRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $physicalPerson = (new LegalPerson())
            ->setName($faker->company)
            ->setCnpj($faker->cnpj(false))
            ->setIe($faker->rg(false));

        if (!in_array('Address', $except)) {
            $physicalPerson->addAddress((new AddressRepositoryTest())->getMockObject(['Person']));
        }

        if (!in_array('Phone', $except)) {
            $physicalPerson->addPhone((new PhoneRepositoryTest())->getMockObject(['Person']));
        }

        return $physicalPerson;
    }
}
