<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\ItemType;
use App\Enumerator\ValueType;

class ItemTypeRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $itemType = (new ItemType())
            ->setName($faker->name)
            ->setSlug($faker->word)
            ->setValueType($faker->randomElement(ValueType::getValues()))
            ->setEquipmentType((new EquipmentTypeRepositoryTest())->getMockObject());

        return $itemType;
    }
}
