<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Criteria;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CriteriaFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const CRITERIA_REFERENCE = 'CRITERIA_REFERENCE';

    public function load(ObjectManager $manager)
    {
        // $faker = $this->getFaker();

        // $criteria = (new Criteria())
            // ->setRule($this->getReference(RuleFixtures::RULE_REFERENCE))
            // ->setTemplateCriteria('(:expr-1)');

        // $manager->persist($criteria);
        // $manager->flush();

        // $this->addReference(self::CRITERIA_REFERENCE, $criteria);
    }

    public function getDependencies()
    {
        return [
            RuleFixtures::class,
        ];
    }
}
