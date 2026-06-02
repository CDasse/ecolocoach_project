<?php

namespace App\Service;


use App\Entity\Event;
use App\Entity\Level;
use App\Repository\EventRepository;

readonly class EventService
{
    public function __construct(
        private EventRepository $eventRepository,
    )
    {
    }

    public function findOneEventInLevel(Level $level, int $sequenceNumber): ?Event
    {
        return $this->eventRepository->findOneEventInLevel($level, $sequenceNumber);
    }

    public function findNextEvent(Event $currentEvent): ?Event
    {
        return $this->eventRepository->findNextEvent($currentEvent);
    }

    /**
     * Calculates the chronological sequence number of an event relative strictly to its own type within its level.
     * * Instead of using the global sequence number, this filters all events in the level by their EventType
     * (e.g., LESSON or CHALLENGE) to compute a type-specific rank index.
     */
    public function findTypeSequenceNumber(Event $event): ?int
    {
        $eventsOfLevel = $this->findEventsInLevel($event->getLevel());

        $typeNumber = 0;

        foreach ($eventsOfLevel as $levelEvent) {
            if ($levelEvent->getEventType() === $event->getEventType()) {
                $typeNumber++;
            }

            if ($levelEvent->getId() === $event->getId()) {
                break;
            }
        }

        return $typeNumber;
    }

    public function findEventsInLevel(Level $level): array
    {
        return $this->eventRepository->findEventsInLevel($level);
    }
}
