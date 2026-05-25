<?php

namespace App\Controller;

use App\Service\Co2EquivalenceService;
use App\Service\MessageEncouragementService;
use App\Service\XUserLevelEventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ImpactController extends AbstractController
{
    #[Route('/impact', name: 'impact', methods: ['GET'])]
    public function impact(
        Co2EquivalenceService $co2equivalenceService,
        MessageEncouragementService $messageEncouragementService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        $connectedUser = $this->getUser();
        $userCo2Impact = $connectedUser->getCo2Impact();

        $equivalentCo2Impact = $co2equivalenceService->getCo2Equivalence($userCo2Impact);

        $messageEncouragement = $messageEncouragementService->findOneRandomMessageEncouragement();

        dd($challengesAccepted = $xUserLevelEventService->findAcceptedChallenges($connectedUser));

        return $this->render('impact/index.html.twig', [
            'equivalent_impact' => $equivalentCo2Impact,
            'message_encouragement' => $messageEncouragement,
            'challenges_accepted' => $challengesAccepted,
        ]);
    }
}
