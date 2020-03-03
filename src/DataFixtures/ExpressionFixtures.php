<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Expression;
use App\Enumerator\FunctionType;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ExpressionFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const EXPRESSION_REFERENCE = 'EXPRESSION_REFERENCE';

    public function load(ObjectManager $manager)
    {
        // $documentManager = $this->container->get('doctrine_mongodb')->getManager();
        // $faker = $this->getFaker();

        // $history = $this->getReference(HistoryFixtures::HISTORY_REFERENCE, $documentManager);

        // $expression = (new Expression())
            // ->setItem('aa')
            // ->setItemType($this->getReference(ItemTypeFixtures::ITEM_TYPE_REFERENCE))
            // ->setCriteria($this->getReference(CriteriaFixtures::CRITERIA_REFERENCE))
            // ->setLogicalComparator('==')
            // ->setValue($history->getValue())
            // ->setSequence(1)
            // ->setFunction($faker->randomElement(FunctionType::getValues()));

        // $manager->persist($expression);
        // $manager->flush();

        // $this->addReference(self::EXPRESSION_REFERENCE, $expression);
    }

    public function getDependencies()
    {
        return [
            CriteriaFixtures::class,
            // HistoryFixtures::class,
            ItemTypeFixtures::class,
        ];
    }
}
