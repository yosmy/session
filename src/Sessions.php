<?php

namespace Yosmy;

use Yosmy\Mongo;

class Sessions extends Mongo\Collection
{
    /**
     * @var Session[]
     */
    protected $cursor;
}

