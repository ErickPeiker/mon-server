<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\LegalPerson;
use Doctrine\Common\Persistence\ObjectManager;

class LegalPersonFixtures extends BaseFixture
{
    public const LEGAL_PERSON_REFERENCE = 'LEGAL_PERSON_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $legalPerson = (new LegalPerson())
            ->setName('Legal Person ' . ($manager->getRepository(LegalPerson::class)->findAll()->count() + 1))
            ->setCnpj($faker->cnpj(false))
            ->setIe($faker->rg(false));

        $manager->persist($legalPerson);
        $manager->flush();

        $this->addReference(self::LEGAL_PERSON_REFERENCE, $legalPerson);
    }
}
