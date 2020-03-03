<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\EquipmentType;

class EquipmentTypeRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $equipmentType = (new EquipmentType())
            ->setName($faker->name)
            ->setSlug($faker->word);

        return $equipmentType;
    }
}
