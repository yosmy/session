<?php

namespace Yosmy;

use Yosmy;
use Traversable;

/**
 * @di\service()
 */
class AuditMissingSessions
{
    /**
     * @var ManageSessionCollection
     */
    private $manageSessionCollection;

    /**
     * @param ManageSessionCollection $manageSessionCollection
     */
    public function __construct(
        ManageSessionCollection $manageSessionCollection
    ) {
        $this->manageSessionCollection = $manageSessionCollection;
    }

    /**
     * @param Yosmy\Mongo\ManageCollection $manageCollection
     *
     * @return Traversable
     */
    public function audit(
        Yosmy\Mongo\ManageCollection $manageCollection
    ): Traversable
    {
        return $manageCollection->aggregate(
            [
                [
                    '$lookup' => [
                        'localField' => '_id',
                        'from' => $this->manageSessionCollection->getName(),
                        'as' => 'sessions',
                        'foreignField' => 'user',
                    ]
                ],
                [
                    '$match' => [
                        'sessions.user' => [
                            '$exists' => false
                        ]
                    ],
                ]
            ]
        );
    }
}