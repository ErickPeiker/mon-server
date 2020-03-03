<?php

namespace App\DataFixtures;

use App\Base\Doctrine\Common\DataFixtures\BaseFixture;
use App\Entity\Company;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture implements DependentFixtureInterface
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $company = $this->getReference(CompanyFixtures::COMPANY_REFERENCE);

        $user = new User();
        $user->setEmail('user' . ($manager->getRepository(User::class)->findAll()->count() + 1) . '@example.com.br')
            ->setPassword($this->userPasswordEncoder->encodePassword($user, '123123'))
            ->setRoles(['ROLE_USER'])
            ->setPhysicalPerson($this->getReference(PhysicalPersonFixtures::USER_PERSON_REFERENCE))
            ->addGroup($this->getReference(GroupFixtures::GROUP_REFERENCE))
            ->setCompany($company)
            ->addCompany($company);

        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            GroupFixtures::class,
            PhysicalPersonFixtures::class,
        ];
    }
}
