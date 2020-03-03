<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\IncidentType;

class IncidentTypeRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $incidentType = (new IncidentType())
            ->setName($faker->name)
            ->setSequence($faker->randomDigitNotNull)
            ->setBackgroundColor($faker->hexcolor)
            ->setTextColor($faker->hexcolor);

        return $incidentType;
    }
}
