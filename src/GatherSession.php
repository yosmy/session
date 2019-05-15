<?php

namespace Yosmy;

use LogicException;

/**
 * @di\service()
 */
class GatherSession
{
    /**
     * @var PickSession
     */
    private $pickSession;

    /**
     * @param PickSession $pickSession
     */
    public function __construct(PickSession $pickSession)
    {
        $this->pickSession = $pickSession;
    }

    /**
     * @param string|null $id
     * @param string|null $user
     * @param string|null $device
     *
     * @return Session
     */
    public function gather(
        ?string $id,
        ?string $user,
        ?string $device
    ): Session {
        try {
            return $this->pickSession->pick(
                $id,
                $user,
                $device
            );
        } catch (NonexistentSessionException $e) {
            throw new LogicException(null, null, $e);
        }
    }
}
