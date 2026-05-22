<?php

namespace App\Service;

use App\Entity\EventPage;
use App\Entity\EventPart;
use App\Repository\EventPartRepository;

class EventPartService
{
    public function __construct(
        private readonly EventPartRepository $eventPartRepository,
    )
    {
    }

    public function findEventPartsInEventPage(EventPage $eventPage): array
    {
        return $this->eventPartRepository->findEventPartsInEventPage($eventPage);
    }

    public function findRightAnswerOfPreviousPage(EventPage $previousPage): ?EventPart
    {
        return $this->eventPartRepository->findRightAnswerOfPreviousPage($previousPage);
    }

}
