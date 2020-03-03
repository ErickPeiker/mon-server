<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Enumerator\CompanyType;
use App\Entity\Company;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const COMPANY_REFERENCE = 'COMPANY_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $company = (new Company())
            ->setLegalPerson($this->getReference(LegalPersonFixtures::LEGAL_PERSON_REFERENCE))
            ->setType(CompanyType::COMPANY_RESALE)
            ->setCompany($manager->getRepository(Company::class)->find('c88d4129-4763-47f5-9010-a734e19ea7da'));

        $manager->persist($company);
        $manager->flush();

        $this->addReference(self::COMPANY_REFERENCE, $company);
    }

    public function getDependencies()
    {
        return [
            LegalPersonFixtures::class,
        ];
    }
}
