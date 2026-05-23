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

/**
 * Processes the signup form submission, instantiates the user record alongside
 * its roadmap starter tokens.
 */
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
        // Form Validation
        // Checks if the user form is submitted and valid, then loads the initial structural
        // objects (default path, first level, first event) to hook the newcomer into the system.
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            $defaultPath = $pathService->findDefaultPath();
            $defaultLevel = $levelService->findOneLevelInPath($defaultPath, 1);
            $defaultEvent = $eventService->findOneEventInLevel($defaultLevel, 1);

            // Throw error if default path isn't define
            if (!$defaultPath) {
                throw new \RuntimeException('Inability to bootstrap registration: Default Path is missing from the database. Did you forget to load fixtures or run migrations?');
            }

            // User Account Provisioning
            // Hashes the credential payload, attaches application-level roles, assigns
            // the default visual assets, and ties the record to the default entry path.
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(['ROLE_USER']);
            $user->setLogo("uploads/logos/default.png");
            $user->setPath($defaultPath);
            $entityManager->persist($user);


            // Progression Bootstrapping & Completion
            // Initializes a fresh tracking entity linking the newly created user to their very
            // first roadmap milestone as 'ACTIVE'.
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
