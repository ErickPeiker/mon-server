<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Dashboard;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DashboardFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const DASHBOARD_REFERENCE = 'DASHBOARD_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $widgetChart = (new Dashboard())
            ->setName('Dashboard ' . ($manager->getRepository(Dashboard::class)->findAll()->count() + 1))
            ->setCompany($this->getReference(CompanyFixtures::COMPANY_REFERENCE));

        $manager->persist($widgetChart);
        $manager->flush();

        $this->addReference(self::DASHBOARD_REFERENCE, $widgetChart);
    }

    public function getDependencies()
    {
        return [
            CriteriaFixtures::class,
        ];
    }
}
