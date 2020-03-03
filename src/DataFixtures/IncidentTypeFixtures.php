<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\IncidentType;
use Doctrine\Common\Persistence\ObjectManager;

class IncidentTypeFixtures extends BaseFixture
{
    public const INCIDENT_TYPE_REFERENCE = 'INCIDENT_TYPE_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $count = $manager->getRepository(IncidentType::class)->findAll()->count() + 1;

        $incidentType = (new IncidentType())
            ->setName('Incident Type ' . $count)
            ->setSequence($faker->randomDigitNotNull)
            ->setBackgroundColor($faker->hexcolor)
            ->setTextColor($faker->hexcolor);

        $manager->persist($incidentType);
        $manager->flush();

        $this->addReference(self::INCIDENT_TYPE_REFERENCE, $incidentType);
    }
}
