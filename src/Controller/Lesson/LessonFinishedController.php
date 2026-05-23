<?php

namespace App\Controller\Lesson;

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

final class LessonFinishedController extends AbstractController
{
    #[Route('/event/{uid}/lesson_finished', name: 'lesson_finished', methods: ['POST'])]
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
            $progression->setEventStatus(EventStatus::FINISHED);
            $entityManager->persist($progression);

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
        }

        return $this->redirectToRoute('path');
    }
}
