<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventPage;
use App\Service\EventPageService;
use App\Service\EventPartService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    #[Route('/event/{uid}/{pageNumber}', name: 'event', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        int $pageNumber,
        EventPageService $eventPageService,
        EventPartService $eventPartService
    ): Response
    {
        $eventPage = $eventPageService->findOneEventPageInEvent($event, $pageNumber);

        $eventParts = $eventPartService->findEventPartsInEventPage($eventPage);

        $totalPages = $eventPageService->countTotalPagesForEvent($event);


        return $this->render('event/index.html.twig', [
            'event' => $event,
            'event_parts' => $eventParts,
            'page_number' => $pageNumber,
            'total_pages' => $totalPages,
        ]);
    }
}
