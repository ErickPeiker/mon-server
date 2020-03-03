<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Phone;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PhoneFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $phone = (new Phone())
            ->setPerson($this->getReference(PhysicalPersonFixtures::USER_PERSON_REFERENCE))
            ->setNumber($faker->cellphoneNumber(false, true));

        $manager->persist($phone);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PhysicalPersonFixtures::class,
        ];
    }
}
