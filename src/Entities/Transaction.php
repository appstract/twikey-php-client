<?php

namespace Appstract\Twikey\Entities;

use Appstract\Twikey\Entity;

class Transaction extends Entity
{
    protected $connection;

    protected $endpoint = 'transaction';
}
