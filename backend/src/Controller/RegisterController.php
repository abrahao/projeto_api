<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Ajuste para a interface correta
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher; // Ajuste do tipo
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher, // Ajuste do tipo
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Email and password are required.'], Response::HTTP_BAD_REQUEST);
        }

        // Verificar se o e-mail já está registrado
        if ($this->userRepository->findOneBy(['email' => $email])) {
            return new JsonResponse(['error' => 'Email is already registered.'], Response::HTTP_BAD_REQUEST);
        }

        // Criar o novo usuário
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password)); // Uso correto do hashPassword
        $user->setRoles(['ROLE_USER']); // Adicionar papéis conforme necessário

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'User registered successfully.'], Response::HTTP_CREATED);
    }
}
