<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Service\EventPageService;
use App\Service\EventPartService;
use App\Service\XUserLevelEventService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Handles asynchronous HTTP requests to dynamically populate the modal window layout.
 * Resolves specific challenge layout pages, aggregates structural parts, and evaluates user progression state.
 */
final class ChallengePopUpController extends AbstractController
{
    #[Route('/challenge/{uid}/pop_up', name: 'challenge_pop_up', methods: ['GET'])]
    public function challengePopup(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventPageService $eventPageService,
        EventPartService $eventPartService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        // Layout Blueprint & Structural Content Mapping
        // Locates the foundational page for the event and extracts all structured layout elements (image, label, etc.).
        $eventPage = $eventPageService->findOneEventPageInEvent($event, 1);
        $eventParts = $eventPartService->findEventPartsInEventPage($eventPage);


        // Progression Tracking Lookup
        // Evaluates whether the currently connected user has accepted, rejected, or terminated the challenge.
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        return $this->render('event/_event_components/_challenge_pop_up.html.twig', [
            'event' => $event,
            'event_parts' => $eventParts,
            'progression' => $progression
        ]);
    }
}
