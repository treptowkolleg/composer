<?php

namespace Core\Model;


trait IdEntityTrait
{

    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

}
