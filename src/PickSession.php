<?php

namespace Yosmy;

interface PickSession
{
    /**
     * @param string|null $id
     * @param string|null $user
     * @param string|null $device
     *
     * @return Session
     *
     * @throws NonexistentSessionException
     */
    public function pick(
        ?string $id,
        ?string $user,
        ?string $device
    ): Session;
}
