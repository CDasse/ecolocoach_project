<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Service\EventPageService;
use App\Service\EventPartService;
use App\Service\XUserLevelEventService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChallengePopUpController extends AbstractController
{
    #[Route('/challenge/{uid}/pop_up', name: 'challenge_pop_up')]
    public function challengePopup(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventPageService $eventPageService,
        EventPartService $eventPartService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        $eventPage = $eventPageService->findOneEventPageInEvent($event, 1);
        $eventParts = $eventPartService->findEventPartsInEventPage($eventPage);

        $connectedUser = $this->getUser();
        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        return $this->render('event/_event_components/_challenge_pop_up.html.twig', [
            'event' => $event,
            'event_parts' => $eventParts,
            'progression' => $progression
        ]);
    }
}
