<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\XUserLevelEvent;
use App\Enum\EventStatus;
use App\Enum\EventType;
use App\Service\EventService;
use App\Service\XUserLevelEventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventFinishedController extends AbstractController
{
    #[Route('/event/{uid}/{eventStatus}', name: 'event_finished', requirements: ['eventStatus' => 'Terminé|Accepté|Refusé'], methods: ['POST']) ]
    public function eventFinished(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventStatus $eventStatus,
        EntityManagerInterface $entityManager,
        EventService  $eventService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        if ($event->getEventType() == EventType::LESSON && $eventStatus !== EventStatus::FINISHED) {
            $eventStatus = EventStatus::FINISHED;
        }

        if ($event->getEventType() == EventType::DEFI && $eventStatus !== EventStatus::ACCEPTED && $eventStatus !== EventStatus::REFUSED) {
            $eventStatus = EventStatus::REFUSED;
        }

        $connectedUser = $this->getUser();

        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        if ($progression) {
            $progression->setEventStatus($eventStatus);
            $entityManager->persist($progression);
        }

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

        if ($eventStatus == EventStatus::ACCEPTED) {
            $this->addFlash('success',
                '<strong>BRAVO !</strong> Tu viens d’accepter le défi. <br>On a hâte que tu vives cette expérience ! <br>
                            Tu peux retrouver tes défis en cours dans l’onglet “MON IMPACT” et les valider une fois réalisés.');
        }

        if ($eventStatus == EventStatus::REFUSED) {
            $this->addFlash('info',
                "<strong>CE N'EST PAS GRAVE !</strong> <br>Que tu ne sois pas prêt.e ou que tu ne puisses pas réaliser ce défi, ce n’est pas grave. Beaucoup d’autres défis t’attendent ! <br>
                        Si par la suite, tu souhaites retenter ce défi, rends-toi dans la liste de tes défis annulés.");
        }

        return $this->redirectToRoute('path');
    }
}
