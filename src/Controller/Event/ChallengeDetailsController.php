<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Service\EventPageService;
use App\Service\EventPartService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChallengeDetailsController extends AbstractController
{
    #[Route('/challenge/{uid}/details', name: 'challenge_details')]
    public function challengeDetails(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventPageService $eventPageService,
        EventPartService $eventPartService,
    ): Response
    {
        $eventPage = $eventPageService->findOneEventPageInEvent($event, 1);
        $eventParts = $eventPartService->findEventPartsInEventPage($eventPage);

        return $this->render('event/_event_components/_challenge_details.html.twig', [
            'event' => $event,
            'event_parts' => $eventParts,
        ]);
    }
}
