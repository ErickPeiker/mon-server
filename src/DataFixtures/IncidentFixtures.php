<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Incident;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class IncidentFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $incidentType = $this->getReference(IncidentTypeFixtures::INCIDENT_TYPE_REFERENCE);

        $incident = (new Incident())
            ->setDescription($faker->text)
            ->setIncidentType($incidentType->toArray())
            ->setCompany($this->getReference(CompanyFixtures::COMPANY_REFERENCE));

        $manager->persist($incident);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActionFixtures::class,
            CompanyFixtures::class,
            IncidentTypeFixtures::class,
        ];
    }
}
