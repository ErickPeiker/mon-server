<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\ItemType;
use App\Enumerator\ValueType;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ItemTypeFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const ITEM_TYPE_REFERENCE = 'ITEM_TYPE_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $count = $manager->getRepository(ItemType::class)->findAll()->count() + 1;

        $itemType = (new ItemType())
            ->setName('Item Type ' . $count)
            ->setSlug('item-type-' . $count)
            ->setValueType(ValueType::VALUE_INTEGER)
            ->setEquipmentType($this->getReference(EquipmentTypeFixtures::EQUIPMENT_TYPE_REFERENCE));

        $manager->persist($itemType);
        $manager->flush();

        $this->addReference(self::ITEM_TYPE_REFERENCE, $itemType);
    }

    public function getDependencies()
    {
        return [
            EquipmentTypeFixtures::class,
        ];
    }
}
