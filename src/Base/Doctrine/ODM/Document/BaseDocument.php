<?php

namespace App\Base\Doctrine\ODM\Document;

use App\Base\Doctrine\Common\Traits\ToArrayTrait;

abstract class BaseDocument
{
    use ToArrayTrait;

    abstract protected function getFillable();

    abstract public function getOnlyStore();

    public function getOnlyUpdate() {
        return $this->getOnlyStore();
    }
}
