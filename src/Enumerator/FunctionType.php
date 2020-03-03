<?php

namespace App\Enumerator;

use App\Base\Doctrine\Common\Enumerator\BaseEnumerator;

class FunctionType extends BaseEnumerator
{
    const FUNCTION_AVG = 'FUNCTION_AVG';
    const FUNCTION_COUNT = 'FUNCTION_COUNT';
    const FUNCTION_DATE = 'FUNCTION_DATE';
    const FUNCTION_DAY_OF_MONTH = 'FUNCTION_DAY_OF_MONTH';
    const FUNCTION_DAY_OF_WEEK = 'FUNCTION_DAY_OF_WEEK';
    const FUNCTION_DIFF = 'FUNCTION_DIFF';
    const FUNCTION_HOUR = 'FUNCTION_HOUR';
    const FUNCTION_LAST = 'FUNCTION_LAST';

    protected static $values = [
        self::FUNCTION_AVG,
        self::FUNCTION_COUNT,
        self::FUNCTION_DATE,
        self::FUNCTION_DAY_OF_MONTH,
        self::FUNCTION_DAY_OF_WEEK,
        self::FUNCTION_DIFF,
        self::FUNCTION_HOUR,
        self::FUNCTION_LAST,
    ];
}
