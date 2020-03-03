<?php

namespace App\Enumerator;

use App\Base\Doctrine\Common\Enumerator\BaseEnumerator;

class ValueType extends BaseEnumerator
{
    const VALUE_FLOAT = 'VALUE_FLOAT';
    const VALUE_INTEGER = 'VALUE_INTEGER';
    const VALUE_VARCHAR = 'VALUE_VARCHAR';

    protected static $values = [
        self::VALUE_FLOAT,
        self::VALUE_INTEGER,
        self::VALUE_VARCHAR,
    ];
}
