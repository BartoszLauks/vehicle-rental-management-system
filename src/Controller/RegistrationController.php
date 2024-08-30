<?php

namespace App\Controller;

use App\DTO\User\UserDTO;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

//#[Route('/security', name: 'security', format: 'json')]
final class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager,
//        private readonly StringGenerator $stringGenerator,
        private readonly UserFactory $userFactory,
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // do anything else you need here, like send an email

            return $this->security->login($user, AppAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    // Example. Converting form request body to DTO object class with serialization and single throw exception validation
    #[Route('/api/register', name: 'api_register', methods: 'POST', format: 'json')]
    public function registerApi(
        #[MapRequestPayload(
            serializationContext: ['groups' => ['api_register']],
            validationGroups: ['api_register'],
//            validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
        )] UserDTO $userDTO
    ): Response
    {
        $user = $this->userFactory->createFromDTO($userDTO);
        $this->userRepository->save($user);

        return $this->json(['message' => 'User was created.'],Response::HTTP_CREATED);
    }
}
