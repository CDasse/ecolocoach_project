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

    public function findEventInLevel(?Level $level, int $sequenceNumber) : ?Event {
        return $this->eventRepository->findEventInLevel($level, $sequenceNumber);
    }

}
