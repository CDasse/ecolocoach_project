<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\EventStatus;
use App\Service\XUserLevelEventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Compiles and exposes the comprehensive historical breakdown of a user's challenge ecosystem.
 * Segregates user actions into atomic telemetry lists: ongoing, successfully completed, and rejected.
 */
final class RecapChallengesController extends AbstractController
{
    #[Route('/impact/recap-challenges', name: 'recap_challenges', methods: ['GET'])]
    public function recapChallenges(
        XUserLevelEventService $xUserLevelEventService,
    ): Response
    {
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();

        $challengesAccepted = $xUserLevelEventService->findChallengesByStatus($connectedUser, EventStatus::ACCEPTED);
        $challengesFinished = $xUserLevelEventService->findChallengesByStatus($connectedUser, EventStatus::FINISHED);
        $challengesRefused = $xUserLevelEventService->findChallengesByStatus($connectedUser, EventStatus::REFUSED);

        return $this->render('recap_challenges/index.html.twig', [
            'challenges_accepted' => $challengesAccepted,
            'challenges_finished' => $challengesFinished,
            'challenges_refused' => $challengesRefused,
        ]);
    }
}
