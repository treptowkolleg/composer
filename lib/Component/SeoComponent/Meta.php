<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\SeoComponent;

class Meta
{

    private array $meta;

    public function __construct(array $meta)
    {
        foreach($meta as $key => $value)
        {
            self::add($key,$value);
        }
    }

    /**
     * @param string $name key name of the meta value
     * @return string
     */
    public function get(string $name): string
    {
        return $this->meta[$name] ?? 'n/a';
    }

    /**
     * @param string $key key name of the meta value
     * @param string $value corresponding value
     * @return Meta
     */
    public function add(string $key, string $value): Meta
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * @param string $key key name of the meta value
     * @param string $value corresponding value
     * @param string|null $delimiter delimiter between last and new string
     * @param bool $space enable or disable spacer. Defaults to true
     * @return $this
     */
    public function append(string $key, string $value, string $delimiter = null, bool $space = true): Meta
    {
        if(null == $delimiter)
        {
            $this->meta[$key] .= $value;
        } elseif($space) {
            $this->meta[$key] .= " {$delimiter} {$value}";
        } else {
            $this->meta[$key] .= "{$delimiter}{$value}";
        }

        return $this;
    }

}
