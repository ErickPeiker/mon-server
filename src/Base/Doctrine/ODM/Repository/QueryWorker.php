<?php

namespace App\Base\Doctrine\ODM\Repository;

use App\Base\Doctrine\Common\Repository\BaseQueryWorker;

class QueryWorker extends BaseQueryWorker
{
    public function __construct($repository)
    {
        $this->manager = $repository->getManager();
        $this->repository = $repository;
        $this->queryBuilder = $this->repository->createQueryBuilder();
        $this->classMetadata = $this->repository->getClassMetadata();
    }

    public function getResult()
    {
        return $this->getQuery()->execute()->toArray();
    }

    public function getOneResult()
    {
        return $this->getQuery()->execute()->getSingleResult();
    }

    public function select($fields)
    {
        $this->queryBuilder->select($fields);

        return $this;
    }

    public function andWhere($field, $operation, $value = null)
    {
        $this->queryBuilder->addAnd($this->makeExpression($field, $operation, $value));

        return $this;
    }

    public function orderBy($field, $order = 'ASC')
    {
        $this->queryBuilder->sort($field, $order);

        return $this;
    }

    public function paginate($limit = 25, $page = 0)
    {
        if ($limit > 0) {
            $this->queryBuilder->limit($limit);
        }

        if ($page > 0) {
            $this->queryBuilder->skip($page * $limit);
        }

        return $this;
    }

    protected function makeExpression($field, $operation, $value = null)
    {
        switch ($operation) {
            case 'equals':
                $expression = $this->queryBuilder->expr()->field($field)->equals($value);
                break;
            case 'exists':
                $expression = $this->queryBuilder->expr()->field($field)->exists($value === null ? true : $value);
                break;
            case 'notEquals':
                $expression = $this->queryBuilder->expr()->field($field)->notEqual($value);
                break;
            case 'greaterThan':
                $expression = $this->queryBuilder->expr()->field($field)->gt($value);
                break;
            case 'greaterThanOrEquals':
                $expression = $this->queryBuilder->expr()->field($field)->gte($value);
                break;
            case 'lessThan':
                $expression = $this->queryBuilder->expr()->field($field)->lt($value);
                break;
            case 'lessThanOrEquals':
                $expression = $this->queryBuilder->expr()->field($field)->lte($value);
                break;
            case 'isNull':
                $expression = $this->queryBuilder->expr()->field($field)->equals(null);
                break;
            case 'isNotNull':
                $expression = $this->queryBuilder->expr()->field($field)->notEqual(null);
                break;
            case 'in':
                $expression = $this->queryBuilder->expr()->field($field)->in($value);
                break;
            case 'notIn':
                $expression = $this->queryBuilder->expr()->field($field)->notIn($value);
                break;
            case 'like':
                $expression = $this->queryBuilder->expr()->field($field)->equals(new \MongoRegex('/' . $value . '/i'));
                break;
            case 'notLike':
                $expression = $this->queryBuilder->expr()->field($field)->not(new \MongoRegex('/' . $value . '/i'));
                break;
            case 'between':
                $expression = $this->queryBuilder->expr()->field($field)->gt($value[0])->lt($value[1]);
                break;
            default:
                abort(400, "Operation '{$operation}' not recognized!");
        }

        return $expression;
    }

    private function makeExpressions($conditions)
    {
        $expressions = [];

        foreach ($conditions as $condition) {
            $expressions[] = $this->makeExpression($condition['field'], $condition['operation'], $condition['value']);
        }

        return $expressions;
    }
}
