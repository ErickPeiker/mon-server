<?php

namespace App\Enumerator;

use App\Base\Doctrine\Common\Enumerator\BaseEnumerator;

class ActionType extends BaseEnumerator
{
    const ACTION_INCIDENT = 'ACTION_INCIDENT';

    protected static $values = [
        self::ACTION_INCIDENT,
    ];
}
