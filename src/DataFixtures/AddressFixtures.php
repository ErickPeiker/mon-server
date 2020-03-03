<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Address;
use App\Entity\City;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AddressFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $userAddress = (new Address())
            ->setPerson($this->getReference(PhysicalPersonFixtures::USER_PERSON_REFERENCE))
            ->setCity($faker->randomElement($manager->getRepository(City::class)->findAll()->getResult()))
            ->setPostcode($faker->bothify('########'))
            ->setStreet($faker->streetName)
            ->setNumber($faker->buildingNumber)
            ->setObservation($faker->text);

        $manager->persist($userAddress);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PhysicalPersonFixtures::class,
        ];
    }
}
