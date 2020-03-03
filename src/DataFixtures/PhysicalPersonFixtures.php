<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\PhysicalPerson;
use Doctrine\Common\Persistence\ObjectManager;

class PhysicalPersonFixtures extends BaseFixture
{
    public const USER_PERSON_REFERENCE = 'USER_PERSON_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $userPhysicalPerson = (new PhysicalPerson())
            ->setName('Physical Person ' . ($manager->getRepository(PhysicalPerson::class)->findAll()->count() + 1))
            ->setCpf($faker->cpf(false))
            ->setRg($faker->rg(false))
            ->setBirthdate($faker->dateTime)
            ->setGender($faker->randomElement(['MASCULINO', 'FEMININO']))
            ->setMaritalStatus($faker->randomElement(['SOLTEIRO', 'CASADO']));

        $manager->persist($userPhysicalPerson);
        $manager->flush();

        $this->addReference(self::USER_PERSON_REFERENCE, $userPhysicalPerson);
    }
}
