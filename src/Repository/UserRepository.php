<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends GenericRepository
{


    public function __construct()
    {
        parent::__construct(User::class);
    }
}