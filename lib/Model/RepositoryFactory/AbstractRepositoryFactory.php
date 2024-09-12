<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Model\RepositoryFactory;

use Core\Model\QueryBuilder;

abstract class AbstractRepositoryFactory implements RepositoryFactoryInterface
{

    protected string $entity;

    protected QueryBuilder $queryBuilder;

    public function __construct(string $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param string $entity ORM entity class representing the database table
     * @param string|null $alias alias of the base table
     * @return QueryBuilder
     */
    protected function QueryBuilder(string $entity, string $alias = null): QueryBuilder
    {
        return $this->queryBuilder = new QueryBuilder($entity,$alias);
    }

    /**
     * @return false|int
     */
    public function count()
    {
        return $this->queryBuilder($this->entity)
            ->getQuery()
            ->getCountResult()
        ;

    }

    /**
     * @return false|int
     */
    public function countDistinctBy(string $column)
    {
        return $this->queryBuilder($this->entity)
            ->selectDistinct($column)
            ->getQuery()
            ->getCountResult()
        ;

    }

    public function find($id)
    {
        return $this->queryBuilder($this->entity)
            ->selectOrm()
            ->andWhere('id = :id')
            ->setParameter('id',$id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;

    }

    public function findAll(array $orderBy = [], int $limit = null, int $offset = null ): array
    {
        $query = $this->queryBuilder($this->entity)
            ->selectOrm()
            ->orderBy($orderBy)
        ;

        if(null !== $limit)
        {
            $query->setMaxResults($limit);
        }

        if(null !== $offset)
        {
            $query->setFirstResult($offset);
        }

        return $query
            ->getQuery()
            ->getResult()
        ;

    }

    public function findBy(array $data, array $orderBy = [], int $limit = null, int $offset = null): array
    {
        $query = $this->queryBuilder($this->entity)
            ->selectOrm()
            ->orderBy($orderBy)
        ;

        if(0 !== count($data))
        {
            foreach ($data as $key => $value)
            {
                $query->andWhere($this->makeCondition($key, $value));
                if(!is_bool($value))
                {
                    $query->setParameter($key, $value);
                }
            }
        }

        if(null !== $limit)
        {
            $query->setMaxResults($limit);
        }

        if(null !== $offset)
        {
            $query->setFirstResult($offset);
        }

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBy(array $data)
    {
        $query = $this->queryBuilder($this->entity)
            ->selectOrm()
        ;

        if(0 !== count($data))
        {
            foreach ($data as $key => $value)
            {
                $query->andWhere($this->makeCondition($key, $value));
                if(!is_bool($value))
                {
                    $query->setParameter($key, $value);
                }
            }
        }

        return $query
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    private function makeCondition(string $key, $value): string
    {
        $condition = null;
        switch(strtoupper(gettype($value))){

            case 'NULL':
                $condition = "$key IS NULL";
                break;

            case 'BOOLEAN':
                $condition = ($value) ? "$key IS NOT NULL" : "$key IS NULL" ;
                break;

            default:
                $condition = "$key = :$key";
                break;
        }

        return $condition;
    }

}
