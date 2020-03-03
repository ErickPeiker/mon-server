<?php

namespace  App\Base\Helper;

use DateTime;
use InvalidArgumentException;

class FormatHelper
{
    public static function parseDate($date, $from = 'Y-m-d', $to = 'obj')
    {
        if (!is_string($from)) {
            throw new InvalidArgumentException('Formato de entrada inválido');
        }

        if (!is_string($to)) {
            throw new InvalidArgumentException('Formato de saída inválido');
        }

        if ($date instanceof DateTime && $to === 'obj') {
            return $date;
        }

        if ($date instanceof DateTime) {
            return $date->format($to);
        }

        $dateObject = DateTime::createFromFormat($from, $date);

        if ($dateObject) {
            if ($to === 'obj') {
                return $dateObject;
            }

            if (is_string($to)) {
                return $dateObject->format($to);
            }
        }

        throw new InvalidArgumentException(
            sprintf(
                'Não foi possível converter a data "%s" do formato "%s" para o formato "%s"',
                $date,
                $from,
                $to
            )
        );
    }
}
