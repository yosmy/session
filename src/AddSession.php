<?php

namespace Yosmy;

interface AddSession
{
    /**
     * @param string $user
     * @param string $device
     */
    public function add(
        string $user,
        string $device
    );
}