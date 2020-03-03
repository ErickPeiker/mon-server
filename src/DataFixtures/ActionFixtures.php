<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Action;
use App\Enumerator\ActionType;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ActionFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const ACTION_INCIDENT_REFERENCE = 'ACTION_INCIDENT_REFERENCE';

    public function load(ObjectManager $manager)
    {
        // $faker = $this->getFaker();

        // $actionIncident = (new Action())
            // ->setParameters([])
            // ->setType(ActionType::ACTION_INCIDENT)
            // ->setCriteria($this->getReference(CriteriaFixtures::CRITERIA_REFERENCE));

        // $manager->persist($actionIncident);
        // $manager->flush();

        // $this->addReference(self::ACTION_INCIDENT_REFERENCE, $actionIncident);
    }

    public function getDependencies()
    {
        return [
            CriteriaFixtures::class,
        ];
    }
}
