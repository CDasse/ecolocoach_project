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

final class DefiAcceptedController extends AbstractController
{
    #[Route('/event/{uid}/defi_accepted', name: 'defi_accepted', methods: ['POST'])]
    public function index(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EntityManagerInterface $entityManager,
        EventService  $eventService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        $connectedUser = $this->getUser();

        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        if ($progression) {
            $progression->setEventStatus(EventStatus::ACCEPTED);
            $entityManager->persist($progression);

            $this->addFlash('success',
                '<strong>BRAVO !</strong> Tu viens d’accepter le défi. <br>On a hâte que tu vives cette expérience ! <br>
Tu peux retrouver tes défis en cours dans l’onglet “MON IMPACT” et les valider une fois réalisés.');
        }

        $nextEvent = $eventService->findNextEvent($event);

        if ($nextEvent) {
            $newProgression = new XUserLevelEvent();
            $newProgression->setTargetUser($connectedUser);
            $newProgression->setLevel($event->getLevel());
            $newProgression->setEvent($nextEvent);
            $newProgression->setEventStatus(EventStatus::ACTIVE);

            $entityManager->persist($newProgression);
        }

        $entityManager->flush();

        return $this->redirectToRoute('path');
    }
}
