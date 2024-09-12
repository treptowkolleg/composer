<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\MenuComponent;

abstract class AbstractMenuType
{
    protected string $label = '';
    protected string $route = '#';
    protected array $attrib = [];
    protected array $class = [];

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Menu
     */
    public function setLabel(string $label): AbstractMenuType
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return Menu
     */
    public function setRoute(string $route): AbstractMenuType
    {

        $this->route = $route;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttrib(): array
    {

        return $this->attrib;
    }

    /**
     * @param $key
     * @param $value
     * @return Menu
     */
    public function setAttrib($key, $value = null): AbstractMenuType
    {
        if($value)
        {
            $this->attrib[$key][] = $value;
        } else {
                $this->attrib = $key;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getClass(): array
    {

        return $this->class;
    }

    /**
     * @param $key
     * @param $value
     * @return Menu
     */
    public function setClass($key, $value = null): AbstractMenuType
    {
        if($value)
        {
            $this->class[$key][] = $value;
        } else {
            $this->class = $key;
        }

        return $this;
    }

}
