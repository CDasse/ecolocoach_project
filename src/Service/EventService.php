<?php

namespace App\Service;


use App\Entity\Event;
use App\Entity\Level;
use App\Repository\EventRepository;

class EventService
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    )
    {
    }

    public function findOneEventInLevel(Level $level, int $sequenceNumber) : ?Event {
        return $this->eventRepository->findOneEventInLevel($level, $sequenceNumber);
    }

    public function findEventsInLevel(Level $level): array
    {
        return $this->eventRepository->findEventsInLevel($level);
    }

    public function findNextEvent(Event $currentEvent): ?Event
    {
        return $this->eventRepository->findNextEvent($currentEvent);
    }

}
