<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\EventStatus;
use App\Service\Co2EquivalenceService;
use App\Service\MessageEncouragementService;
use App\Service\XUserLevelEventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Generates the personalized user "My Impact" dashboard overview.
 * Consolidates aggregate CO2 metrics, computes real-world environmental equivalences,
 * selects motivational content, and segments active challenges.
 */
final class ImpactController extends AbstractController
{
    #[Route('/impact', name: 'impact', methods: ['GET'])]
    public function impact(
        Co2EquivalenceService $co2equivalenceService,
        MessageEncouragementService $messageEncouragementService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        // User Context & Core Metrics Retrieval
        // Fetches the authenticated user instance and extracts their cumulative environmental impact.
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $userCo2Impact = $connectedUser->getCo2Impact();

        // Environmental Calculations & Motivation Content
        // Translates raw metrics into practical real-life examples and fetches a randomized encouragement text.
        $equivalentCo2Impact = $co2equivalenceService->getCo2Equivalence($userCo2Impact);
        $messageEncouragement = $messageEncouragementService->findOneRandomMessageEncouragement();

        // Challenge Tracking
        // Collects active challenges to give them to the view.
        $challengesAccepted = $xUserLevelEventService->findChallengesByStatus($connectedUser, EventStatus::ACCEPTED);

        return $this->render('impact/index.html.twig', [
            'equivalent_impact' => $equivalentCo2Impact,
            'message_encouragement' => $messageEncouragement,
            'challenges_accepted' => $challengesAccepted,
        ]);
    }
}
