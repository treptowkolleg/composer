<?php

namespace Core\Dto;

final class TableDto
{

    private string $caption;
    private array $columns;

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     * @return TableDto
     */
    public function setCaption(string $caption): TableDto
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     * @return TableDto
     */
    public function setColumns(array $columns): TableDto
    {
        $this->columns = $columns;
        return $this;
    }



}