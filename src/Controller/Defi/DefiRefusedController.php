<?php

namespace App\Controller\Defi;

use App\Entity\Event;
use App\Entity\XUserLevelEvent;
use App\Enum\EventStatus;
use App\Service\EventService;
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
    EventService $eventService,
    XUserLevelEventService $xUserLevelEventService
): Response
{
    $connectedUser = $this->getUser();

    $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

    if ($progression) {
        $progression->setEventStatus(EventStatus::REFUSED);
        $entityManager->persist($progression);

        $this->addFlash('info',
            "<strong>CE N'EST PAS GRAVE !</strong> <br>Que tu ne sois pas prêt.e ou que tu ne puisses pas réaliser ce défi, ce n’est pas grave. Beaucoup d’autres défis t’attendent ! <br>
                        Si par la suite, tu souhaites retenter ce défi, rends-toi dans la liste de tes défis annulés.");

        $nextEvent = $eventService->findNextEvent($event);

        if ($nextEvent) {
            $nextProgression = $xUserLevelEventService->findProgression($connectedUser, $nextEvent);

            if (!$nextProgression) {
                $newProgression = new XUserLevelEvent();
                $newProgression->setTargetUser($connectedUser);
                $newProgression->setLevel($event->getLevel());
                $newProgression->setEvent($nextEvent);
                $newProgression->setEventStatus(EventStatus::ACTIVE);

                $entityManager->persist($newProgression);
            }
        }

        $entityManager->flush();
    }

    return $this->redirectToRoute('path');
}
}
