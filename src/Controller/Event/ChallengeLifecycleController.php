<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Enum\EventStatus;
use App\Service\XUserLevelEventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Manages autonomous user interactions with challenges.
 * Handles state transitions (Accepting, Completing, or Canceling) and updates environmental metrics.
 */
final class ChallengeLifecycleController extends AbstractController
{
    #[Route('/challenge/{uid}/{challengeStatus}', name: 'challenge_lifecycle', requirements: ['challengeStatus' => 'Terminé|Refusé|Accepté'], methods: ['POST'])]
    public function challengeLifecycle(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventStatus $challengeStatus,
        EntityManagerInterface $entityManager,
        XUserLevelEventService $xUserLevelEventService,
        Request $request,
    ): Response
    {
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $referer = $request->headers->get('referer');

        // Progression Guard Clause
        // Verifies if a valid progression tracking instance exists for this specific user/event combination.
        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        if (!$progression) {
            $this->addFlash('error', 'Défi introuvable ou non commencé.');
            return $this->redirect($referer ?? $this->generateUrl('recap_challenges'));
        }

        $eventStatus = $progression->getEventStatus();

        // Immutability Check
        // Prevents any further changes if the challenge has already been successfully accomplished.
        if ($eventStatus == EventStatus::FINISHED) {
            return $this->redirect($referer ?? $this->generateUrl('recap_challenges'));
        }


        // State Transition Security Guard
        // Validates incoming status change requests against the allowed business rules.
        $isChallengeAcceptedStatusOk = ($challengeStatus == EventStatus::FINISHED || $challengeStatus == EventStatus::REFUSED);
        $isChallengeRefusedStatusOk = $challengeStatus == EventStatus::ACCEPTED;

        if ($eventStatus == EventStatus::ACCEPTED && !$isChallengeAcceptedStatusOk) {
            $challengeStatus = EventStatus::REFUSED;
        }

        if ($eventStatus == EventStatus::REFUSED && !$isChallengeRefusedStatusOk) {
            $challengeStatus = EventStatus::REFUSED;
        }


        // State Persistence
        // Applies the sanitized status transition to the database tracker.
        $progression->setEventStatus($challengeStatus);
        $entityManager->persist($progression);


        // Business Logic Processing & Notifications
        // Dispatches reward points (CO2 metrics) and schedules localized flash feedback.
        if ($challengeStatus == EventStatus::ACCEPTED) {
            $this->addFlash('success',
                '<strong>BRAVO !</strong> Tu viens d’accepter le défi. <br>On a hâte que tu vives cette expérience ! <br>
                            Tu peux retrouver tes défis en cours dans l’onglet “MON IMPACT” et les valider une fois réalisés.');
        }

        if ($challengeStatus == EventStatus::FINISHED) {
            $previousCo2Impact = $connectedUser->getCo2Impact();
            $newCo2Impact = $previousCo2Impact + $event->getCo2Impact();

            $connectedUser->setCo2Impact($newCo2Impact);
            $entityManager->persist($connectedUser);

            $this->addFlash('success',
            '<strong>FELICITATIONS !</strong> Tu viens de réaliser le défi. <br>Ton taux de CO2 économisé vient d\'être mis à jour. <br>Continue comme ça !');
        }

        if ($challengeStatus == EventStatus::REFUSED) {
            $this->addFlash('info',
                "<strong>CE N'EST PAS GRAVE !</strong> <br>Que tu ne sois pas prêt.e ou que tu ne puisses pas réaliser ce défi, ce n’est pas grave. Beaucoup d’autres défis t’attendent ! <br>
                        Si par la suite, tu souhaites retenter ce défi, rends-toi dans la liste de tes défis annulés.");
        }

        $entityManager->flush();

        return $this->redirect($referer ?? $this->generateUrl('recap_challenges'));
    }
}
