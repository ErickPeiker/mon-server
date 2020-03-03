<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Rule;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RuleFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const RULE_REFERENCE = 'RULE_REFERENCE';

    public function load(ObjectManager $manager)
    {
        // $faker = $this->getFaker();

        // $rule = (new Rule())
            // ->setName('Rule ' . ($manager->getRepository(Rule::class)->findAll()->count() + 1))
            // ->setCompany($this->getReference(CompanyFixtures::COMPANY_REFERENCE))
            // ->setIsActive($faker->boolean);

        // $manager->persist($rule);
        // $manager->flush();

        // $this->addReference(self::RULE_REFERENCE, $rule);
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
