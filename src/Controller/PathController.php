<?php

namespace App\Controller;

use App\Service\EventService;
use App\Service\LevelService;
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
        LevelService $levelService
    ): Response
    {
        // Progression Context Gathering & View Rendering
        // Detects the authenticated user, evaluates their current milestones through dedicated services,
        // fetches the linked roadmap events, and passes everything to the timeline template.
        $connectedUser = $this->getUser();

        $userCurrentPath = $connectedUser->getPath();
        $userCurrentLevel = $xUserLevelEventService->findUserCurrentLevel($connectedUser);
        $userCurrentEvent = $xUserLevelEventService->findUserCurrentEvent($connectedUser);


        // Handle End of Path
        // If the user has cleared all events, they won't have an active level registration.
        if (!$userCurrentLevel) {
            return $this->render('path/index.html.twig', [
                'user_current_level' => null,
                'user_current_event' => null,
                'events_of_level' => [],
                'next_level' => null,
                'is_path_completed' => true
            ]);
        }


        $eventsOfLevel = $eventService->findEventsInLevel($userCurrentLevel);
        $nextLevel = $levelService->findOneLevelInPath($userCurrentPath, $userCurrentLevel->getSequenceNumber() + 1);

        return $this->render('path/index.html.twig', [
            'user_current_level' => $userCurrentLevel,
            'user_current_event' => $userCurrentEvent,
            'events_of_level' => $eventsOfLevel,
            'next_level' => $nextLevel,
            'is_path_completed' => false
        ]);
    }
}
