<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Enum\EventStatus;
use App\Enum\EventType;
use App\Service\EventService;
use App\Service\LevelService;
use App\Service\XUserLevelEventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Receives and sanitizes a status transition request for a given event, updates the database,
 * activates the next event in the timeline, and triggers contextual flash messages.
 */
final class EventProgressionController extends AbstractController
{
    #[Route('/event/{uid}/{eventStatus}', name: 'event_finished', requirements: ['eventStatus' => 'Terminé|Accepté|Refusé'], methods: ['POST']) ]
    public function eventProgression(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventStatus $eventStatus,
        EntityManagerInterface $entityManager,
        EventService  $eventService,
        LevelService  $levelService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        // Input Sanitization & Security Guards
        // Overrides and corrects the incoming status from the URL to prevent logical bypasses
        $isLessonStatusAccepted = $eventStatus == EventStatus::FINISHED;
        $isChallengeStatusAccepted = ($eventStatus == EventStatus::ACCEPTED || $eventStatus == EventStatus::REFUSED);

        if ($event->getEventType() == EventType::LESSON && !$isLessonStatusAccepted) {
            $eventStatus = EventStatus::FINISHED;
        }

        if ($event->getEventType() == EventType::DEFI && !$isChallengeStatusAccepted) {
            $eventStatus = EventStatus::REFUSED;
        }


        // Current Progression Update
        // Retrieves the active user's tracking row for this specific event and updates its status
        // with the sanitized target state.
        $connectedUser = $this->getUser();
        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        if ($progression) {
            $progression->setEventStatus($eventStatus);
            $entityManager->persist($progression);
        }


        // Next Sequential Event Activation
        // Resolves the next chronological event in the user's path and initializes an 'ACTIVE'
        // progression state for it.
        $hasMovesForward = $xUserLevelEventService->resolveAndActivateNextEventProgression($connectedUser, $event);

        if (!$hasMovesForward) {
            $this->addFlash('success', 'Félicitations ! Vous avez terminé le parcours d\'accompagnement dans votre transition écologique');
        }

        $entityManager->flush();


        // Feedback & Routing Execution
        // Schedules custom confirmation flash messages depending
        // on the user's choices, and redirects them back to the main roadmap.

        if ($eventStatus == EventStatus::ACCEPTED) {
            $this->addFlash('success',
                '<strong>BRAVO !</strong> Tu viens d’accepter le défi. <br>On a hâte que tu vives cette expérience ! <br>
                            Tu peux retrouver tes défis en cours dans l’onglet “MON IMPACT” et les valider une fois réalisés.');
        }

        if ($eventStatus == EventStatus::REFUSED) {
            $this->addFlash('info',
                "<strong>CE N'EST PAS GRAVE !</strong> <br>Que tu ne sois pas prêt.e ou que tu ne puisses pas réaliser ce défi, ce n’est pas grave. Beaucoup d’autres défis t’attendent ! <br>
                        Si par la suite, tu souhaites retenter ce défi, rends-toi dans la liste de tes défis annulés.");
        }

        return $this->redirectToRoute('path');
    }
}
