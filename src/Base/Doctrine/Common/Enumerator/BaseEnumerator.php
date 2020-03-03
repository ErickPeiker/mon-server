<?php

namespace App\Base\Doctrine\Common\Enumerator;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class BaseEnumerator extends StringType
{
    protected $name;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, static::$values)) {
            throw new \InvalidArgumentException("Invalid '".$this->getName()."' value.");
        }

        return $value;
    }

    public function getName()
    {
        $path = explode('\\', get_called_class());
        return array_pop($path);
    }

    public static function getValues()
    {
        return static::$values;
    }
}
