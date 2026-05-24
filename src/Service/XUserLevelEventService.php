<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Enum\EventStatus;
use App\Repository\XUserLevelEventRepository;
use Doctrine\ORM\EntityManagerInterface;

class XUserLevelEventService
{
    public function __construct(
        private readonly XUserLevelEventRepository $xUserLevelEventRepository,
        private readonly EventService $eventService,
        private readonly LevelService $levelService,
        private readonly EntityManagerInterface $entityManager
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

    /**
     * Evaluates the user's current step context and dynamically unlocks either
     * the next sequential event or triggers the next level progression phase.
     * Returns true if a new step was activated, false if the path is fully cleared.
     */

    public function resolveAndActivateNextEventProgression(User $connectedUser, Event $currentEvent) :bool
    {
        $nextEvent = $this->eventService->findNextEvent($currentEvent);

        if ($nextEvent) {
            $this->activateNextEventProgression($connectedUser, $nextEvent);
            return true;
        }

        $currentLevel = $currentEvent->getLevel();
        $nextLevel = $this->levelService->findOneLevelInPath($currentLevel->getPath(), $currentLevel->getSequenceNumber() + 1);

        if ($nextLevel) {
            $nextLevelEvent = $this->eventService->findOneEventInLevel($nextLevel, 1);

            if ($nextLevelEvent) {
                $this->activateNextEventProgression($connectedUser, $nextLevelEvent);
                return true;
            }
        }

        return false;
    }

        /**
     * Validates and initializes a new active tracking record for a user if it doesn't already exist.
     */
    public function activateNextEventProgression(User $user, Event $event): void {
        $nextProgression = $this->findProgression($user, $event);

        if (!$nextProgression) {
            $newProgression = new XUserLevelEvent();
            $newProgression->setTargetUser($user);
            $newProgression->setLevel($event->getLevel());
            $newProgression->setEvent($event);
            $newProgression->setEventStatus(EventStatus::ACTIVE);

            $this->entityManager->persist($newProgression);
        }
    }

}
