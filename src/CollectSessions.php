<?php

namespace Yosmy;

/**
 * @di\service()
 */
class CollectSessions
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
     * @param string|null $user
     * @param array|null  $devices
     * @param int|null    $skip
     * @param int|null    $limit
     *
     * @return Sessions
     */
    public function collect(
        ?string $user,
        ?array $devices,
        ?int $skip,
        ?int $limit
    ): Sessions {
        $criteria = [];

        if ($user !== null) {
            $criteria['user'] = $user;
        }

        if ($devices !== null) {
            $criteria['device'] = ['$in' => $devices];
        }

        $options = [];

        if ($skip !== null) {
            $options['skip'] = $skip;
        }

        if ($limit !== null) {
            $options['limit'] = $limit;
        }

        $cursor = $this->manageCollection->find(
            $criteria,
            $options
        );

        return new Sessions($cursor);
    }
}
