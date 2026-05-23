<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Repository\XUserLevelEventRepository;

class XUserLevelEventService
{
    public function __construct(
        private readonly XUserLevelEventRepository $xUserLevelEventRepository,
    )
    {
    }

    /**
     * Resolves the strict Level entity where the user is currently positioned.
     */
    public function findUserCurrentLevel(User $user): ?Level {
        $xUserLevelEvent = $this->xUserLevelEventRepository->findUserActiveProgression($user);
        return $xUserLevelEvent?->getLevel();
    }

    /**
     * Resolves the exact active Event the user needs to interact with.
     */
    public function findUserCurrentEvent(User $user): ?Event {
        $xUserLevelEvent = $this->xUserLevelEventRepository->findUserActiveProgression($user);
        return $xUserLevelEvent?->getEvent();
    }

    public function findProgression(User $user, Event $event): ?XUserLevelEvent {
        return $this->xUserLevelEventRepository->findProgression($user, $event);
    }

}
