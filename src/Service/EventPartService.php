<?php

namespace App\Service;

use App\Entity\EventPage;
use App\Entity\EventPart;
use App\Repository\EventPartRepository;

readonly class EventPartService
{
    public function __construct(
        private EventPartRepository $eventPartRepository,
    )
    {
    }

    public function findEventPartsInEventPage(EventPage $eventPage): array
    {
        return $this->eventPartRepository->findEventPartsInEventPage($eventPage);
    }

    public function findRightAnswerOfPage(EventPage $page): ?EventPart
    {
        return $this->eventPartRepository->findRightAnswerOfPage($page);
    }
}
