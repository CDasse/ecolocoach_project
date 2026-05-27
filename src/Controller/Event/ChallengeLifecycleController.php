<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Enum\EventStatus;
use App\Enum\EventType;
use App\Service\XUserLevelEventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChallengeLifecycleController extends AbstractController
{
    #[Route('/challenge/{uid}/{challengeStatus}', name: 'challenge_lifecycle', requirements: ['challengeStatus' => 'Terminé|Refusé|Accepté'], methods: ['POST'])]
    public function challengeLifecycle(
        #[MapEntity(mapping: ['uid' => 'uid'])]
        Event $event,
        EventStatus $challengeStatus,
        EntityManagerInterface $entityManager,
        XUserLevelEventService $xUserLevelEventService,
        Request $request,
    ): Response
    {
        $connectedUser = $this->getUser();
        $referer = $request->headers->get('referer');

        $isChallengeAcceptedStatusOk = ($challengeStatus == EventStatus::FINISHED || $challengeStatus == EventStatus::REFUSED);
        $isChallengeRefusedStatusOk = $challengeStatus == EventStatus::ACCEPTED;

        $progression = $xUserLevelEventService->findProgression($connectedUser, $event);

        if (!$progression) {
            $this->addFlash('error', 'Défi introuvable ou non commencé.');
            return $this->redirect($referer ?? $this->generateUrl('recap_challenges'));
        }

        $eventStatus = $progression->getEventStatus();

        if ($eventStatus == EventStatus::ACCEPTED && !$isChallengeAcceptedStatusOk) {
            $challengeStatus = EventStatus::REFUSED;
        }

        if ($eventStatus == EventStatus::REFUSED && !$isChallengeRefusedStatusOk) {
            $challengeStatus = EventStatus::REFUSED;
        }

        if ($eventStatus == EventStatus::FINISHED) {
            return $this->redirect($referer ?? $this->generateUrl('recap_challenges'));
        }

        $progression->setEventStatus($challengeStatus);
        $entityManager->persist($progression);

        if ($challengeStatus == EventStatus::ACCEPTED) {
            $this->addFlash('success',
                '<strong>BRAVO !</strong> Tu viens d’accepter le défi. <br>On a hâte que tu vives cette expérience ! <br>
                            Tu peux retrouver tes défis en cours dans l’onglet “MON IMPACT” et les valider une fois réalisés.');
        }

        if ($challengeStatus == EventStatus::FINISHED) {
            $previousCo2Impact = $connectedUser->getCo2Impact();
            $newCo2Impact = $previousCo2Impact + $event->getCo2Impact();

            $connectedUser->setCo2Impact($newCo2Impact);
            $entityManager->persist($connectedUser);

            $this->addFlash('success',
            '<strong>FELICITATIONS !</strong> Tu viens de réaliser le défi. <br>Ton taux de CO2 économisé vient d\'être mis à jour. <br>Continue comme ça !');
        }

        if ($challengeStatus == EventStatus::REFUSED) {
            $this->addFlash('info',
                "<strong>CE N'EST PAS GRAVE !</strong> <br>Que tu ne sois pas prêt.e ou que tu ne puisses pas réaliser ce défi, ce n’est pas grave. Beaucoup d’autres défis t’attendent ! <br>
                        Si par la suite, tu souhaites retenter ce défi, rends-toi dans la liste de tes défis annulés.");
        }

        $entityManager->flush();

        return $this->redirect($referer ?? $this->generateUrl('recap_challenges'));
    }
}
