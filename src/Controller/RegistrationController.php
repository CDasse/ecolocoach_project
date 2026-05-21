<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\XUserLevelEvent;
use App\Enum\EventStatus;
use App\Form\RegistrationFormType;
use App\Service\EventService;
use App\Service\LevelService;
use App\Service\PathService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        PathService $pathService,
        LevelService $levelService,
        EventService $eventService,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            $defaultPath = $pathService->findDefaultPath();
            $defaultLevel = $levelService->findLevelInPath($defaultPath, 1);
            $defaultEvent = $eventService->findEventInLevel($defaultLevel, 1);

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(['ROLE_USER']);
            $user->setLogo("uploads/logos/default.png");
            $user->setPath($defaultPath);
            $entityManager->persist($user);

            $progressionUser = new XUserLevelEvent();
            $progressionUser->setTargetUser($user);
            $progressionUser->setLevel($defaultLevel);
            $progressionUser->setEvent($defaultEvent);
            $progressionUser->setEventStatus(EventStatus::ACTIVE);
            $entityManager->persist($progressionUser);

            $entityManager->flush();

            $this->addFlash('success', 'Ton compte est créé ! Bienvenue dans EcoloCoach.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
