<?php

namespace Yosmy;

use Yosmy;
use Traversable;
use AppendIterator;
use IteratorIterator;

/**
 * @di\service()
 */
class AuditExtraSessions
{
    /**
     * @var ManageSessionCollection
     */
    private $manageSessionCollection;

    /**
     * @var ManageDeviceCollection
     */
    private $manageDeviceCollection;

    /**
     * @param ManageSessionCollection $manageSessionCollection
     * @param ManageDeviceCollection  $manageDeviceCollection
     */
    public function __construct(
        ManageSessionCollection $manageSessionCollection,
        ManageDeviceCollection $manageDeviceCollection
    ) {
        $this->manageSessionCollection = $manageSessionCollection;
        $this->manageDeviceCollection = $manageDeviceCollection;
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
        $append = new AppendIterator();

        $extra = $this->manageSessionCollection->aggregate(
            [
                [
                    '$lookup' => [
                        'localField' => 'user',
                        'from' => $manageCollection->getName(),
                        'as' => 'parent',
                        'foreignField' => '_id',
                    ]
                ],
                [
                    '$match' => [
                        'parent._id' => [
                            '$exists' => false
                        ]
                    ],
                ]
            ]
        );

        $append->append(new IteratorIterator($extra));

        $extra = $this->manageSessionCollection->aggregate(
            [
                [
                    '$lookup' => [
                        'localField' => 'device',
                        'from' => $this->manageDeviceCollection->getName(),
                        'as' => 'devices',
                        'foreignField' => '_id',
                    ]
                ],
                [
                    '$match' => [
                        'devices._id' => [
                            '$exists' => false
                        ]
                    ],
                ]
            ]
        );

        $append->append(new IteratorIterator($extra));

        return $append;
    }
}