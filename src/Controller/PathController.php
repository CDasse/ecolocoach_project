<?php

namespace App\Controller;

use App\Service\XUserLevelEventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PathController extends AbstractController
{
    #[Route('/path', name: 'path')]
    public function path(
        XUserLevelEventService $xUserLevelEventService,
    ): Response
    {
        $connectedUser = $this->getUser();

        $userCurrentLevel = $xUserLevelEventService->findUserCurrentLevel($connectedUser);

        return $this->render('path/index.html.twig', [
            'user_current_level' => $userCurrentLevel
        ]);
    }
}
