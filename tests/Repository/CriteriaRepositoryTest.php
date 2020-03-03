<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Criteria;

class CriteriaRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $criteria = (new Criteria())
            ->setRule((new RuleRepositoryTest())->getMockObject())
            ->setTemplateCriteria('(:expr-1)');

        return $criteria;
    }
}
