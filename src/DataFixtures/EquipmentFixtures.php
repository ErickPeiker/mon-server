<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Equipment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EquipmentFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const EQUIPMENT_REFERENCE = 'EQUIPMENT_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $equipmentType = $this->getReference(EquipmentTypeFixtures::EQUIPMENT_TYPE_REFERENCE);

        $equipment = (new Equipment())
            ->setName('Equipment ')
            ->setObservation($faker->text)
            ->setIp($faker->ipv4)
            ->setParameters([
                'operationalSystem' => $faker->name,
            ])
            ->setIsActive($faker->boolean)
            ->setEquipmentType($equipmentType)
            ->setCompany($this->getReference(CompanyFixtures::COMPANY_REFERENCE));

        $manager->persist($equipment);
        $manager->flush();

        $this->addReference(self::EQUIPMENT_REFERENCE, $equipment);
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            EquipmentTypeFixtures::class,
        ];
    }
}
