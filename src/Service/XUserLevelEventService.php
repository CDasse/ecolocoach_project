<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Enum\EventStatus;
use App\Repository\XUserLevelEventRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class XUserLevelEventService
{
    public function __construct(
        private XUserLevelEventRepository $xUserLevelEventRepository,
        private EventService              $eventService,
        private LevelService              $levelService,
        private EntityManagerInterface    $entityManager
    )
    {
    }

    /**
     * Resolves the strict Level entity where the user is currently positioned.
     */
    public function findUserCurrentLevel(User $user): ?Level
    {
        $xUserLevelEvent = $this->xUserLevelEventRepository->findUserActiveProgression($user);
        return $xUserLevelEvent?->getLevel();
    }

    /**
     * Resolves the exact active Event the user needs to interact with.
     */
    public function findUserCurrentEvent(User $user): ?Event
    {
        $xUserLevelEvent = $this->xUserLevelEventRepository->findUserActiveProgression($user);
        return $xUserLevelEvent?->getEvent();
    }

    /**
     * Evaluates the user's current step context and dynamically unlocks either
     * the next sequential event or triggers the next level progression phase.
     * Returns a string status indicating the progression result.
     */
    public function resolveAndActivateNextEventProgression(User $connectedUser, Event $currentEvent): string
    {
        $nextEvent = $this->eventService->findNextEvent($currentEvent);

        if ($nextEvent) {
            $this->activateNextEventProgression($connectedUser, $nextEvent);
            return 'NEXT_EVENT';
        }

        $currentLevel = $currentEvent->getLevel();
        $nextLevel = $this->levelService->findOneLevelInPath($currentLevel->getPath(), $currentLevel->getSequenceNumber() + 1);

        if ($nextLevel) {
            $nextLevelEvent = $this->eventService->findOneEventInLevel($nextLevel, 1);

            if ($nextLevelEvent) {
                $this->activateNextEventProgression($connectedUser, $nextLevelEvent);
                return 'NEXT_LEVEL';
            }
        }

        return 'FINISHED_PATH';
    }

    /**
     * Validates and initializes a new active tracking record for a user if it doesn't already exist.
     */
    public function activateNextEventProgression(User $user, Event $event): void
    {
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

    public function findProgression(User $user, Event $event): ?XUserLevelEvent
    {
        return $this->xUserLevelEventRepository->findProgression($user, $event);
    }

    public function findChallengesByStatus(User $user, EventStatus $eventStatus): array
    {
        return $this->xUserLevelEventRepository->findChallengesByStatus($user, $eventStatus);
    }
}
