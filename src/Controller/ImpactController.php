<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ImpactController extends AbstractController
{
    #[Route('/impact', name: 'impact', methods: ['GET'])]
    public function impact(): Response
    {


        return $this->render('impact/index.html.twig', [
            'controller_name' => 'ImpactController',
        ]);
    }
}
