<?php

namespace App\Base\Doctrine\ORM\Entity;

use App\Base\Doctrine\Common\Traits\ToArrayTrait;

abstract class BaseEntity
{
    use ToArrayTrait;

    abstract protected function getFillable();

    abstract public function getOnlyStore();

    public function getOnlyUpdate() {
        return $this->getOnlyStore();
    }
}
