<?php

namespace Appstract\Twikey;

use Appstract\Twikey\Entities;

class Twikey
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __call($entity, $attributes = [])
    {
        $class = "Entities\\".$entity;

        return new $class($this->connection, $attributes);
    }
}
