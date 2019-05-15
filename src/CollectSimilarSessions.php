<?php

namespace Yosmy;

use Yosmy;

/**
 * @di\service()
 */
class CollectSimilarSessions
{
    /**
     * @var GatherSession
     */
    private $gatherSession;

    /**
     * @var CollectSameDevices
     */
    private $collectSameDevices;

    /**
     * @var CollectSessions
     */
    private $collectSessions;

    /**
     * @param GatherSession      $gatherSession
     * @param CollectSameDevices $collectSameDevices
     * @param CollectSessions    $collectSessions
     */
    public function __construct(
        GatherSession $gatherSession,
        CollectSameDevices $collectSameDevices,
        CollectSessions $collectSessions
    ) {
        $this->gatherSession = $gatherSession;
        $this->collectSameDevices = $collectSameDevices;
        $this->collectSessions = $collectSessions;
    }

    /**
     * @param string $session
     *
     * @return Sessions
     */
    public function collect(
        string $session
    ): Sessions {
        $session = $this->gatherSession->gather(
            $session,
            null,
            null
        );

        /** @var Yosmy\Device[] $devices */
        $devices = $this->collectSameDevices->collect(
            $session->getDevice()
        );

        $ids = [];

        foreach ($devices as $i => $device) {
            $ids[$i] = $device->getId();
        }

        return $this->collectSessions->collect(
            null,
            $ids,
            null,
            null
        );
    }
}
