<?php

namespace Yosmy;

/**
 * @di\service()
 */
class BasePickSession implements PickSession
{
    /**
     * @var ManageSessionCollection
     */
    private $manageCollection;

    /**
     * @param ManageSessionCollection $manageCollection
     */
    public function __construct(ManageSessionCollection $manageCollection)
    {
        $this->manageCollection = $manageCollection;
    }

    /**
     * @param string|null $id
     * @param string|null $user
     * @param string|null $device
     *
     * @return Session
     *
     * @throws BaseNonexistentSessionException
     */
    public function pick(
        ?string $id,
        ?string $user,
        ?string $device
    ): Session {
        $criteria = [];

        if ($id !== null) {
            $criteria['_id'] = $id;
        }

        if ($user !== null) {
            $criteria['user'] = $user;
        }

        if ($device !== null) {
            $criteria['device'] = $device;
        }

        /** @var Session $session */
        $session = $this->manageCollection->findOne($criteria);

        if ($session === null) {
            throw new BaseNonexistentSessionException();
        }

        return $session;
    }
}
