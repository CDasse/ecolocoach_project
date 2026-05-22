<?php

namespace App\Controller\Defi;

use App\Entity\Event;
use App\Enum\EventStatus;
use App\Service\XUserLevelEventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefiRefusedController extends AbstractController
{
    #[Route('/event/{uid}/defi_refused', name: 'defi_refused', methods: ['POST'])]
    public function index(
    #[MapEntity(mapping: ['uid' => 'uid'])]
    Event $event,
    EntityManagerInterface $entityManager,
    XUserLevelEventService $xUserLevelEventService
): Response
{
    $connectedUser = $this->getUser();

    $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

    if ($progression) {
        $progression->setEventStatus(EventStatus::REFUSED);
        $entityManager->persist($progression);
        $entityManager->flush();

        $this->addFlash('info',
            "<strong>CE N'EST PAS GRAVE !</strong> <br>Que tu ne sois pas prêt.e ou que tu ne puisses pas réaliser ce défi, ce n’est pas grave. Beaucoup d’autres défis t’attendent ! <br>
                        Si par la suite, tu souhaites retenter ce défi, rends-toi dans la liste de tes défis annulés.");
    }

    return $this->redirectToRoute('path');
}
}
