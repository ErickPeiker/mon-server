<?php

namespace App\Repository;

use App\Entity\Dashboard;
use App\Entity\Group;
use App\Entity\Menu;
use App\Entity\Route;
use App\Entity\User;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRepository extends BaseEntityRepository
{
    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $userPasswordEncoder, TokenStorageInterface $tokenStorage)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;

        parent::__construct($registry, $tokenStorage);
    }

    public function getEntityClass()
    {
        return User::class;
    }

    public function prePersist($entity)
    {
        $entity->setPassword($this->userPasswordEncoder->encodePassword($entity, $entity->getPlainPassword()))
            ->setRoles(['ROLE_USER']);

        if (!$entity->getCompany() && !$entity->getCompanies()->isEmpty()) {
            $entity->setCompany($entity->getCompanies()->first());
        }

        // Cria os dados para empresas novas
        if (!$entity->getCompany()->getId()) {
            // @TODO passar essa função para o prePersist de Company, e no client, criar primeiro a empresa, e depois o usuário
            $dashboard = $this->getManager()->getRepository(Dashboard::class)->createEntity()
                ->setName('Dashboard')
                ->setCompany($entity->getCompany());
            $entity->setDashboard($dashboard);

            $group = $this->getManager()->getRepository(Group::class)->createEntity()
                ->setName('Administrador')
                ->setCompany($entity->getCompany());

            $routes = $this->getManager()->getRepository(Route::class)->findAll()->getResult();
            foreach ($routes as $route) {
                $group->addRoute($route);
            }

            $menus = $this->getManager()->getRepository(Menu::class)->findAll()->getResult();
            foreach ($menus as $menu) {
                $group->addMenu($menu);
            }

            $entity->addGroup($group);
        }
    }

    public function preUpdate($entity)
    {
        // caso o dashboard atual seja de outra empresa
        if (!$entity->getDashboard() || $entity->getDashboard()->getCompany()->getId() !== $entity->getCompany()->getId()) {
            $entity->setDashboard($this->getManager()->getRepository(Dashboard::class)->findBy(['company' => $entity->getCompany()->getId()])->getResult()[0]);
        }

        if ($entity->getPlainPassword()) {
            $entity->setPassword($this->userPasswordEncoder->encodePassword($entity, $entity->getPlainPassword()));
        }
    }

    public function defaultFilters($queryWorker)
    {
        if (($user = $this->getUser()) && $this->getManager()->getFilters()->isEnabled('company')) {
            $queryWorker->andWhere('companies.id', 'equals', $user->getCompany()->getId())
                ->orWhere('id', 'equals', $user->getId());
        }
    }
}
