<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\EquipmentType;
use Doctrine\Common\Persistence\ObjectManager;

class EquipmentTypeFixtures extends BaseFixture
{
    public const EQUIPMENT_TYPE_REFERENCE = 'EQUIPMENT_TYPE_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $count = $manager->getRepository(EquipmentType::class)->findAll()->count() + 1;

        $equipmentType = (new EquipmentType())
            ->setName('Equipment Type ' . $count)
            ->setSlug('equipment-type-' . $count);

        $manager->persist($equipmentType);
        $manager->flush();

        $this->addReference(self::EQUIPMENT_TYPE_REFERENCE, $equipmentType);
    }
}
