<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PathController extends AbstractController
{
    #[Route('/path', name: 'path')]
    public function path(): Response
    {
        return $this->render('path/index.html.twig', [
            'controller_name' => 'PathController',
        ]);
    }
}
