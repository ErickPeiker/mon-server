<?php

namespace App\Base\Doctrine\ORM\Repository;

use App\Base\Doctrine\Common\Repository\BaseQueryWorker;

class QueryWorker extends BaseQueryWorker
{
    const DEFAULT_TABLE_ALIAS = 'u';

    protected $joinedTables = [];

    public function __construct($repository)
    {
        $this->manager = $repository->getManager();
        $this->repository = $repository;
        $this->queryBuilder = $this->repository->createQueryBuilder(self::DEFAULT_TABLE_ALIAS);
        $this->classMetadata = $this->repository->getClassMetadata();
    }

    private function getFullFieldName($field, $alias = self::DEFAULT_TABLE_ALIAS, $separator = '.')
    {
        if ($field) {
            $field = sprintf('%s%s%s', $alias, $separator, $field);
        }

        return $field;
    }

    public function getResult()
    {
        return $this->getQuery()->getResult();
    }

    public function getOneResult()
    {
        return $this->getQuery()->getOneOrNullResult();
    }

    public function select($fields)
    {
        foreach ($fields as $key => $field) {
            $alias = self::DEFAULT_TABLE_ALIAS;
            if (strpos($field, '.') > 0) {
                //monta os joins
                $newAliasField = $this->associationQueryFields($field);
                $alias = $newAliasField['alias'];
                $field = $newAliasField['field'] . ' ' . str_replace('.', '_', $field);
            }
            $queryFields[] = $this->getFullFieldName($field, $alias);
        }

        $this->queryBuilder->select(implode(',', $queryFields));

        return $this;
    }

    public function andWhere($field, $operation, $value = null, $alias = self::DEFAULT_TABLE_ALIAS)
    {
        if (strpos($field, '.') > 0) {
            //monta os joins
            $newAliasField = $this->associationQueryFields($field);
            $alias = $newAliasField['alias'];
            $field = $newAliasField['field'];
        }

        $this->queryBuilder->andWhere($this->makeExpression($this->getFullFieldName($field, $alias), $operation, $value, $alias));

        return $this;
    }

    public function orWhere($field, $operation, $value = null, $alias = self::DEFAULT_TABLE_ALIAS)
    {
        if (strpos($field, '.') > 0) {
            //monta os joins
            $newAliasField = $this->associationQueryFields($field);
            $alias = $newAliasField['alias'];
            $field = $newAliasField['field'];
        }

        $this->queryBuilder->orWhere($this->makeExpression($this->getFullFieldName($field, $alias), $operation, $value, $alias));

        return $this;
    }

    public function orderBy($field, $order = 'ASC', $alias = self::DEFAULT_TABLE_ALIAS)
    {
        if (strpos($field, '.') > 0) {
            //monta os joins
            $newAliasField = $this->associationQueryFields($field);
            $alias = $newAliasField['alias'];
            $field = $newAliasField['field'];
        }

        $this->queryBuilder->addOrderBy($this->getFullFieldName($field, $alias), $order);

        return $this;
    }

    public function paginate($limit = 25, $page = 0)
    {
        if ($limit > 0) {
            $this->queryBuilder->setMaxResults($limit);
        }

        if ($page > 0) {
            $this->queryBuilder->setFirstResult($page * $limit);
        }

        return $this;
    }

    protected function makeExpression($field, $operation, $value = null, $alias = self::DEFAULT_TABLE_ALIAS)
    {
        if (!is_array($value)) {
            $value = $this->queryBuilder->expr()->literal($value);
        }

        switch ($operation) {
            case 'equals':
                $expression = $this->queryBuilder->expr()->eq($field, $value);
                break;
            case 'notEquals':
                $expression = $this->queryBuilder->expr()->neq($field, $value);
                break;
            case 'greaterThan':
                $expression = $this->queryBuilder->expr()->gt($field, $value);
                break;
            case 'greaterThanOrEquals':
                $expression = $this->queryBuilder->expr()->gte($field, $value);
                break;
            case 'lessThan':
                $expression = $this->queryBuilder->expr()->lt($field, $value);
                break;
            case 'lessThanOrEquals':
                $expression = $this->queryBuilder->expr()->lte($field, $value);
                break;
            case 'isNull':
                $expression = $this->queryBuilder->expr()->isNull($field);
                break;
            case 'isNotNull':
                $expression = $this->queryBuilder->expr()->isNotNull($field);
                break;
            case 'in':
                $expression = $this->queryBuilder->expr()->in($field, $value);
                break;
            case 'notIn':
                $expression = $this->queryBuilder->expr()->notIn($field, $value);
                break;
            case 'like':
                $expression = $this->queryBuilder->expr()->like('LOWER('.$field.')', strtolower($value));
                break;
            case 'notLike':
                $expression = $this->queryBuilder->expr()->notLike($field, $value);
                break;
            case 'between':
                $expression = $this->queryBuilder->expr()->between($field, $this->queryBuilder->expr()->literal($value[0]), $this->queryBuilder->expr()->literal($value[1]));
                break;
            default:
                abort(400, "Operation '{$operation}' not recognized!");
        }

        return $expression;
    }

    public function associationQueryFields($completeFieldName)
    {
        $arr = explode('.', $completeFieldName);
        $field = end($arr);

        // Se tiver somente um ponto, e for com o alias default, não é para fazer associação
        if (count($arr) === 2 && $arr[0] === self::DEFAULT_TABLE_ALIAS) {
            return [
                'field' => $field,
                'alias' => self::DEFAULT_TABLE_ALIAS,
            ];
        }

        // Remove o campo e deixa somente as tabelas
        array_pop($arr);

        // Os dados do self iniciais são da tabela inicial do select
        $parentAlias = self::DEFAULT_TABLE_ALIAS;
        $parentMetadata = $this->classMetadata;

        foreach ($arr as $key => $column) {
            // Junta o alias anterior com o nome da tabela para o alias atual
            $alias = "{$parentAlias}_{$column}";

            // Continua somente se tiver associação
            if ($parentMetadata->hasAssociation($column)) {
                $association = $parentMetadata->getAssociationMapping($column);

                $this->setLeftJoin(
                    $this->getFullFieldName($association['fieldName'], $parentAlias),
                    $alias
                );

                $parentAlias = $alias;
                $parentMetadata = $this->manager->getClassMetadata($parentMetadata->getAssociationTargetClass($column));
            }
        }

        return [
            'field' => $field,
            'alias' => $alias,
        ];
    }

    private function setLeftJoin($join, $alias, $field = null, $parentField = null)
    {
        if (!in_array($alias, $this->joinedTables)) {
            if ($field && $parentField) {
                $this->queryBuilder->leftJoin($join, $alias, 'WITH', "{$field} = {$parentField}");
            } else {
                $this->queryBuilder->leftJoin($join, $alias);
            }
            $this->joinedTables[] = $alias;
        }

        return $this;
    }

    private function setJoin($join, $alias, $field = null, $parentField = null)
    {
        if (!in_array($alias, $this->joinedTables)) {
            if ($field && $parentField) {
                $this->queryBuilder->join($join, $alias, 'WITH', "{$field} = {$parentField}");
            } else {
                $this->queryBuilder->join($join, $alias);
            }
            $this->joinedTables[] = $alias;
        }

        return $this;
    }
}
