<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Phone;

class PhoneRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $phone = (new Phone())
            ->setNumber($faker->cellphoneNumber(false, true));

        if (!in_array('Person', $except)) {
            $phone->setPerson((new PhysicalPersonRepositoryTest())->getFlushedMockObject(['Phone']));
        }

        return $phone;
    }
}
