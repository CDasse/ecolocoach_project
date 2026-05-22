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

final class DefiAcceptedController extends AbstractController
{
    #[Route('/event/{uid}/defi_accepted', name: 'defi_accepted', methods: ['POST'])]
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
            $progression->setEventStatus(EventStatus::ACCEPTED);
            $entityManager->persist($progression);
            $entityManager->flush();

            $this->addFlash('success',
                '<strong>BRAVO !</strong> Tu viens d’accepter le défi. <br>On a hâte que tu vives cette expérience ! <br>
Tu peux retrouver tes défis en cours dans l’onglet “MON IMPACT” et les valider une fois réalisés.');
        }

        return $this->redirectToRoute('path');
    }
}
