<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\User;
use App\Service\EventPageService;
use App\Service\EventPartService;
use App\Service\XUserLevelEventService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * This controller displays a specific page of an event and evaluates submitted answers on quiz validation steps.
 */
final class EventController extends AbstractController
{
    #[Route('/event/{uid}/{pageNumber}', name: 'event', requirements: ['pageNumber' => '\d+'], methods: ['GET', 'POST'])]
    public function event(
        Request $request,
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        int $pageNumber,
        EventPageService $eventPageService,
        EventPartService $eventPartService,
        XUserLevelEventService $xUserLevelEventService
    ): Response
    {
        // Data Retrieval
        // Fetches the specific page data, its individual components (pictures, questions, etc.), and the total page count for this event.
        $eventPage = $eventPageService->findOneEventPageInEvent($event, $pageNumber);
        $eventParts = $eventPartService->findEventPartsInEventPage($eventPage);
        $totalPages = $eventPageService->countTotalPagesForEvent($event);


        // Answer Validation
        // Intercepts form submissions to verify if the user's chosen answer matches the expected right answer from the question page.
        $isCorrectAnswer = null;

        if ($request->isMethod('post')) {
            $userAnswer = $request->request->get('selected_answer');
            $previousPage = $eventPageService->findOneEventPageInEvent($event, $pageNumber - 1);
            $rightAnswer = $eventPartService->findRightAnswerOfPage($previousPage)->getRightAnswer();

            if ($userAnswer == $rightAnswer) {
                $isCorrectAnswer = true;
            } else {
                $isCorrectAnswer = false;
            }
        }

        // User Tracking & Rendering
        // Retrieves the authenticated user's current progression status for this event and passes all contextual data to the Twig template.
        /** @var User $connectedUser */
        $connectedUser = $this->getUser();
        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        return $this->render('event/index.html.twig', [
            'event' => $event,
            'event_parts' => $eventParts,
            'page_number' => $pageNumber,
            'total_pages' => $totalPages,
            'is_correct_answer' => $isCorrectAnswer,
            'progression' => $progression,
        ]);
    }
}
