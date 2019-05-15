<?php

namespace Yosmy;

use Yosmy\Mongo;
use Yosmy;

class BaseSession extends Mongo\Document implements Session, Yosmy\Related
{
    /**
     * @param string $id
     * @param string $user
     * @param string $device
     */
    public function __construct(
        string $id,
        string $user,
        string $device
    ) {
        parent::__construct([
            '_id' => $id,
            'user' => $user,
            'device' => $device
        ]);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->offsetGet('_id');
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->offsetGet('user');
    }

    /**
     * @return string
     */
    public function getDevice(): string
    {
        return $this->offsetGet('device');
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): object
    {
        $data = parent::jsonSerialize();

        $data->id = $data->_id;

        unset($data->_id);

        return $data;
    }
}
