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

    public function findUserCurrentLevel(User $user): ?Level {
        $xUserLevelEvent = $this->xUserLevelEventRepository->findUserCurrentLevel($user);
        return $xUserLevelEvent?->getLevel();
    }

    public function findUserCurrentEvent(User $user): ?Event {
        $xUserLevelEvent = $this->xUserLevelEventRepository->findUserCurrentEvent($user);
        return $xUserLevelEvent?->getEvent();
    }

}
