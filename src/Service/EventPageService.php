<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\EventPage;
use App\Repository\EventPageRepository;

class EventPageService
{
    public function __construct(
        private readonly EventPageRepository $eventPageRepository,
    )
    {
    }

    public function findOneEventPageInEvent(Event $event, int $sequenceNumber): ?EventPage
    {
        return $this->eventPageRepository->findOneEventPageInEvent($event, $sequenceNumber);
    }

}
