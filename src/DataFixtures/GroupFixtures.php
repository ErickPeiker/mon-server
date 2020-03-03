<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Company;
use App\Entity\Group;
use App\Entity\Menu;
use App\Entity\Route;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GroupFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const GROUP_REFERENCE = 'GROUP_REFERENCE';

    public function load(ObjectManager $manager)
    {
        $group = (new Group())
            ->setName('Grupo ' . ($manager->getRepository(Group::class)->findAll()->count() + 1))
            ->setCompany($this->getReference(CompanyFixtures::COMPANY_REFERENCE));

        $routes = $manager->getRepository(Route::class)->findAll()->getResult();
        foreach ($routes as $route) {
            $group->addRoute($route);
        }

        $menus = $manager->getRepository(Menu::class)->findAll()->getResult();
        foreach ($menus as $menu) {
            $group->addMenu($menu);
        }

        $manager->persist($group);
        $manager->flush();

        $this->addReference(self::GROUP_REFERENCE, $group);
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
