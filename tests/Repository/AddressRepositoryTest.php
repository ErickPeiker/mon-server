<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Address;
use App\Entity\City;

class AddressRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $this->setUp();

        $faker = $this->getFaker();

        $city = $faker->randomElement($this->manager->getRepository(City::class)->findAll()->getResult());

        $address = (new Address())
            ->setCity($city)
            ->setPostcode($faker->bothify('########'))
            ->setStreet($faker->streetName)
            ->setNumber($faker->buildingNumber)
            ->setObservation($faker->text);

        if (!in_array('Person', $except)) {
            $address->setPerson((new PhysicalPersonRepositoryTest())->getFlushedMockObject(['Address']));
        }

        return $address;
    }
}
