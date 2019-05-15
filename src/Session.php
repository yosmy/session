<?php

namespace Yosmy;

interface Session
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @return string
     */
    public function getDevice(): string;
}
