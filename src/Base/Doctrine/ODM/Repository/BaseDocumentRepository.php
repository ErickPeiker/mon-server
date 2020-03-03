<?php

namespace App\Base\Doctrine\ODM\Repository;

use App\Base\Doctrine\Common\Repository\BaseRepository;
use Doctrine\ODM\MongoDB\DocumentRepository;

class BaseDocumentRepository extends DocumentRepository
{
    use BaseRepository;

    public function getManager()
    {
        return parent::getDocumentManager();
    }

    public function createQueryWorker()
    {
        $queryWorker = new QueryWorker($this);
        $this->defaultFilters($queryWorker);

        return $queryWorker;
    }
}
