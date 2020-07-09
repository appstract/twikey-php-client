<?php

namespace Appstract\Twikey;

class Twikey
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __call($entity, $attributes = [])
    {
        $class = "Appstract\Twikey\Entities\\".ucfirst($entity);

        return new $class($this->connection, $attributes);
    }
}
