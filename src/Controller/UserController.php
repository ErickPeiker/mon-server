<?php

namespace App\Controller;

use App\Base\Controller\CrudController;
use App\Entity\User;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends CrudController
{
    protected function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository(User::class);
    }

    public function switchCompanyAction(Request $request, $companyId)
    {
        $em = $this->getRepository()->getEntityManager();
        $user = $this->getUser();

        $em->getFilters()->disable('company');

        $company = $this->getDoctrine()->getRepository(Company::class)->find($companyId);

        $user->setCompany($company);

        $em->persist($user);
        $em->flush();

        return new JsonResponse($user->toArray());
    }
}
