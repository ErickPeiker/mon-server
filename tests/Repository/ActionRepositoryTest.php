<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Action;
use App\Enumerator\ActionType;

class ActionRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $action = (new Action())
            ->setParameters([])
            ->setType($faker->randomElement(ActionType::getValues()))
            ->setCriteria((new CriteriaRepositoryTest)->getMockObject());

        return $action;
    }
}
