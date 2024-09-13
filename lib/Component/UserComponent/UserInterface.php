<?php

namespace Core\Component\UserComponent;

interface UserInterface
{

    public function getUsername(): string;

    public function getPassword(): string;

}