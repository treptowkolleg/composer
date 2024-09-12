<?php

namespace Core\Component\TemplateComponent;

use Core\Dto\TableDto;

final class TableComponent
{

    private TableDto $dto;

    private function __construct(TableDto $tableDto)
    {
        $this->dto = $tableDto;
    }

    public static function new(): self
    {
        $dto = new TableDto();
        return new self($dto);
    }

}