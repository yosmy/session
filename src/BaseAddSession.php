<?php

namespace Yosmy;

/**
 * @di\service()
 */
class BaseAddSession implements AddSession
{
    /**
     * @var ManageSessionCollection
     */
    private $manageCollection;

    /**
     * @param ManageSessionCollection $manageCollection
     */
    public function __construct(
        ManageSessionCollection $manageCollection
    ) {
        $this->manageCollection = $manageCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function add(
        string $user,
        string $device
    ) {
        $this->manageCollection->insertOne([
            '_id' => uniqid(),
            'user' => $user,
            'device' => $device
        ]);
    }
}