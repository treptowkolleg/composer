<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\ConfigComponent;

trait ConfigArrayTrait
{

    protected array $argument;

    /**
     * @return string|array
     */
    protected function getArgument(string $name)
    {
        return $this->argument[$name];
    }

    public function getArguments(): array
    {
        return $this->argument;
    }

    /**
     * @param array $data
     * @return Config
     */
    protected function setArgument(array $data): AbstractConfig
    {
        foreach ($data as $key => $value)
        {
            $this->argument[$key] = $value;
        }
        return $this;
    }



}