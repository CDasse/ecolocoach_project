<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\EventPage;
use App\Repository\EventPageRepository;

readonly class EventPageService
{
    public function __construct(
        private EventPageRepository $eventPageRepository,
    )
    {
    }

    public function findOneEventPageInEvent(Event $event, int $sequenceNumber): ?EventPage
    {
        return $this->eventPageRepository->findOneEventPageInEvent($event, $sequenceNumber);
    }

    public function countTotalPagesForEvent(Event $event): int
    {
        return $this->eventPageRepository->countTotalPagesForEvent($event);
    }
}
