<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Widget;
use App\Enumerator\WidgetType;

class WidgetRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $widget = (new Widget())
            ->setName($faker->name)
            ->setType($faker->randomElement(WidgetType::getValues()))
            ->setGridPosition(['lg' => ''])
            ->setDashboard((new DashboardRepositoryTest())->getMockObject());

        return $widget;
    }
}
