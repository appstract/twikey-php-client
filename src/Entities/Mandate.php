<?php

namespace Appstract\Twikey\Entities;

use Appstract\Twikey\Entity;

class Mandate extends Entity
{
    protected $connection;

    protected $endpoint = 'mandate';

    public function find($id)
    {
        return $this->makeFromResponse(
            $this->connection()->get($this->endpoint().'/detail?mndtId='.$id)
        );
    }
}
