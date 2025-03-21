<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;


final class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): JsonResponse
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsersController.php',
        ]);
    }

    #[Route('/users/add-user')]
    public function addUser(EntityManagerInterface $entityManager): Response
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $user = new Users();

        $user->setMail('bonjour@mail.com');
        $user->setFirstname('Toto');
        $user->setLastname('Titi');
        $user->setIsAdmin(false);
        $user->setUsername('Totodu93');
        $user->setPassword('kill *****!');

        $entityManager->persist($user);
        
        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }

    #[Route('/users/{id}', methods: ['GET'])]
    public function showUser(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $user = $entityManager->getRepository(Users::class)->find($id);
        
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return $this->json([
            'id' => $user->getId(),
            'mail' => $user->getMail(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'isAdmin' => $user->isAdmin(),
            'username' => $user->getUsername(),
        ]);
    }
}
