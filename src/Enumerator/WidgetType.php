<?php

namespace App\Enumerator;

use App\Base\Doctrine\Common\Enumerator\BaseEnumerator;

class WidgetType extends BaseEnumerator
{
    const WIDGET_CHART = 'WIDGET_CHART';

    protected static $values = [
        self::WIDGET_CHART,
    ];
}
