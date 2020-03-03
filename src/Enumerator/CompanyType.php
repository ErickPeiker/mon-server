<?php

namespace App\Enumerator;

use App\Base\Doctrine\Common\Enumerator\BaseEnumerator;

class CompanyType extends BaseEnumerator
{
    const COMPANY_CLIENT = 'COMPANY_CLIENT';
    const COMPANY_MASTER = 'COMPANY_MASTER';
    const COMPANY_RESALE = 'COMPANY_RESALE';

    protected static $values = [
        self::COMPANY_CLIENT,
        self::COMPANY_MASTER,
        self::COMPANY_RESALE,
    ];
}
