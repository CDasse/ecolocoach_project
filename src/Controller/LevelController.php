<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LevelController extends AbstractController
{
    #[Route('/level', name: 'level', methods: ['GET'])]
    public function level(): Response
    {
        return $this->render('level/index.html.twig', [
            'controller_name' => 'LevelController',
        ]);
    }
}
