<?php

namespace Appstract\Pakketpartner\Entities;

use Appstract\Pakketpartner\Connection;
use Appstract\Pakketpartner\Entity;

class Label extends Entity
{
    protected $connection;

    protected $endpoint = 'shipments/labels';
}
