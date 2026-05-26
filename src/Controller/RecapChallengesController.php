<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecapChallengesController extends AbstractController
{
    #[Route('/impact/recap-challenges', name: 'recap_challenges')]
    public function recapChallenges(): Response
    {
        return $this->render('recap_challenges/index.html.twig', [
            'controller_name' => 'RecapChallengesController',
        ]);
    }
}
