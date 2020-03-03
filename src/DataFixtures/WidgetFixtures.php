<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Widget;
use App\Enumerator\WidgetType;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class WidgetFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const WIDGET_CHART_REFERENCE = 'WIDGET_CHART_REFERENCE';

    public function load(ObjectManager $manager)
    {
        // $documentManager = $this->container->get('doctrine_mongodb')->getManager();
        $faker = $this->getFaker();

        $count = $manager->getRepository(Widget::class)->findAll()->count();

        $widgetChart = (new Widget())
            ->setName('Widget Chart ' . ($count + 1))
            ->setType($faker->randomElement(WidgetType::getValues()))
            ->setDashboard($this->getReference(DashboardFixtures::DASHBOARD_REFERENCE))
            ->setParameters([
                'chartType' => 'donut',
                'equipments' => [$this->getReference(EquipmentFixtures::EQUIPMENT_REFERENCE)->getId()],
                'historyLimiter' => '5',
                'itemLimiter' => '5',
                'itemType' => $this->getReference(ItemTypeFixtures::ITEM_TYPE_REFERENCE)->getId(),
                'refresh' => '5',
                'showLegend' => true,
                'showOthers' => true,
            ]);

        $manager->persist($widgetChart);
        $manager->flush();

        $this->addReference(self::WIDGET_CHART_REFERENCE, $widgetChart);
    }

    public function getDependencies()
    {
        return [
            EquipmentFixtures::class,
            DashboardFixtures::class,
            ItemTypeFixtures::class,
        ];
    }
}
