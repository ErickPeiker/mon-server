<?php

namespace App\Tests\Repository;

use App\Base\Test\Repository\BaseRepositoryTest;
use App\Entity\Expression;
use App\Enumerator\FunctionType;

class ExpressionRepositoryTest extends BaseRepositoryTest
{
    public function getMockObject(array $except = [])
    {
        $faker = $this->getFaker();

        $expression = (new Expression())
            ->setItem($faker->word) // @TODO buscar do teste de Item
            ->setItemType((new ItemTypeRepositoryTest())->getMockObject())
            ->setCriteria((new CriteriaRepositoryTest())->getMockObject())
            ->setLogicalComparator('==')
            ->setValue($faker->word) // @TODO buscar do teste de Item
            ->setSequence(1)
            ->setFunction($faker->randomElement(FunctionType::getValues()));

        return $expression;
    }
}
