<?php

namespace App\Controller;

use App\Service\EventService;
use App\Service\XUserLevelEventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Renders the roadmap dashboard by gathering the current progression context of the logged-in user.
 */
final class PathController extends AbstractController
{
    #[Route('/path', name: 'path')]
    public function path(
        XUserLevelEventService $xUserLevelEventService,
        EventService $eventService,
    ): Response
    {
        // Progression Context Gathering & View Rendering
        // Detects the authenticated user, evaluates their current milestones through dedicated services,
        // fetches the linked roadmap events, and passes everything to the timeline template.
        $connectedUser = $this->getUser();

        $userCurrentLevel = $xUserLevelEventService->findUserCurrentLevel($connectedUser);
        $userCurrentEvent = $xUserLevelEventService->findUserCurrentEvent($connectedUser);
        $eventsOfLevel = $eventService->findEventsInLevel($userCurrentLevel);

        return $this->render('path/index.html.twig', [
            'user_current_level' => $userCurrentLevel,
            'user_current_event' => $userCurrentEvent,
            'events_of_level' => $eventsOfLevel,
        ]);
    }
}
