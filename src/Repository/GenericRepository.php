<?php

namespace App\Repository;

use Core\Model\RepositoryFactory\AbstractRepositoryFactory;

class GenericRepository extends AbstractRepositoryFactory
{

    public function __construct(string $entity)
    {
        parent::__construct($entity);
    }

    public function setEntity(string $entity): GenericRepository
    {
        $this->entity = $entity;
        return $this;
    }

}