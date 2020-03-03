<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Company;
use App\Enumerator\CompanyType;

class CompanyRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $company = (new Company())
            ->setLegalPerson((new LegalPersonRepositoryTest)->getMockObject())
            ->setType(CompanyType::COMPANY_MASTER);

        return $company;
    }
}
