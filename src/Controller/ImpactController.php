<?php

namespace App\Controller;

use App\Service\Co2EquivalenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ImpactController extends AbstractController
{
    #[Route('/impact', name: 'impact', methods: ['GET'])]
    public function impact(
        Co2EquivalenceService $co2equivalenceService,
    ): Response
    {
        $connectedUser = $this->getUser();
        $userCo2Impact = $connectedUser->getCo2Impact();

        $equivalentCo2Impact = $co2equivalenceService->getCo2Equivalence($userCo2Impact);

        return $this->render('impact/index.html.twig', [
            'equivalent_impact' => $equivalentCo2Impact,
        ]);
    }
}
