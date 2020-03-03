<?php

namespace App\Repository;

use App\Entity\Company;
use App\Base\Doctrine\ORM\Repository\BaseEntityRepository;

class CompanyRepository extends BaseEntityRepository
{
    public function getEntityClass()
    {
        return Company::class;
    }

    public function defaultFilters($queryWorker)
    {
        if ($user = $this->getUser()) {
            $companies = $user->getCompanies()->map(function ($company) {
                return $company->getId();
            })->toArray();

            if ($this->getManager()->getFilters()->isEnabled('company')) {
                $companies = [$user->getCompany()->getId()];
            }

            $queryWorker->andWhere('id', 'in', $companies)
                ->orWhere('company.id', 'in', $companies)
                ->orWhere('company.company.id', 'in', $companies);
        }
    }
}
