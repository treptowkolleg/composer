<?php

namespace Core\Model;

use DateTime;

trait DateTimeEntityTrait
{

    protected string $created;
    protected ?string $updated;

    public function getCreated(): DateTime
    {
        return DateTime::createFromFormat('Y-m-d H:i:s',$this->created);
    }

    public function getUpdated(): ?DateTime
    {
        return ($this->updated) ? DateTime::createFromFormat('Y-m-d H:i:s',$this->updated) : null;
    }

}
