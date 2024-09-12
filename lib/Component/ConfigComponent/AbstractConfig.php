<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\ConfigComponent;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractConfig
{

    use ConfigArrayTrait;

    public function __construct(string $file)
    {
        $file = "/{$file}";
        try {
            $this->setArgument(Yaml::parseFile(project_root.$file));
        } catch (ParseException $parseException)
        {
            echo $parseException->getParsedFile();
        }

    }

    public function setConfig(Array $data): self
    {
        $this->setArgument($data);
        return $this;
    }

    public function getConfig(string $name)
    {
        return $this->getArgument($name);
    }

}