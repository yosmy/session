<?php

namespace Yosmy;

use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.relate_user'
 *     ]
 * })
 */
class RelateUserBySession implements Yosmy\RelateUser
{
    /**
     * @var GatherSession
     */
    private $gatherSession;

    /**
     * @var CollectSessions
     */
    private $collectSessions;

    /**
     * @var Yosmy\CollectSimilarSessions
     */
    private $collectSimilarSessions;

    /**
     * @param GatherSession      $gatherSession
     * @param CollectSessions    $collectSessions
     * @param CollectSimilarSessions $collectSimilarSessions
     */
    public function __construct(
        GatherSession $gatherSession,
        CollectSessions $collectSessions,
        CollectSimilarSessions $collectSimilarSessions
    ) {
        $this->gatherSession = $gatherSession;
        $this->collectSessions = $collectSessions;
        $this->collectSimilarSessions = $collectSimilarSessions;
    }

    /**
     * {@inheritDoc}
     */
    public function relate(
        string $user,
        array $included
    ): array {
        /** @var Session[] $sessionsByUser */
        $sessionsByUser = $this->collectSessions->collect(
            $user,
            null,
            null,
            null
        );

        foreach ($sessionsByUser as $sessionByUser) {
            if (isset($included[$sessionByUser->getId()])) {
                continue;
            }

            $included[$sessionByUser->getId()] = $sessionByUser;

            /** @var Session[] $sessionsBySameDevice */
            $sessionsBySameDevice = $this->collectSimilarSessions->collect(
                $sessionByUser->getId()
            );

            foreach ($sessionsBySameDevice as $sessionBySameDevice) {
                if (isset($included[$sessionBySameDevice->getId()])) {
                    continue;
                }

                $included[$sessionBySameDevice->getId()] = $sessionBySameDevice;

                $included = $this->relate(
                    $sessionBySameDevice->getUser(),
                    $included
                );
            }
        }

        return $included;
    }
}
