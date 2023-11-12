<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api')]
class AuthenticationController extends AbstractController
{

    private UserService $service;
    public function __construct()
    {
        $this->service = new UserService();
    }

    #[Route('/auth/register', name: 'register', methods: ['POST'])]
//    #[OA\Response(
//        response: 200,
//        description: 'Returns the rewards of an user',
//        content: new OA\JsonContent(
//            type: 'object',
//            properties:[
//                new OA\Property('name', type: 'string',),
//                new OA\Property('pass', type: 'string'),
//            ]
//        )
//    )]

    #[OA\Post(
        operationId: 'user-register',
        summary: 'Register',
        tags: ['Authorization'],
//        responses: [
//            new OA\Response(response: 201, description: 'user-register'),
//            new OA\Response(response: 400, description: 'Bad request')
//        ],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        nullable: false
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        nullable: false
                    ),
                ])
            ),
        ]
    )]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager,ValidatorInterface $validator ): Response
    {
        try {
            $params = json_decode($request->getContent());
            $user = $this->service->store($params, $passwordEncoder, $entityManager,$validator);
            return $user;

        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }

}
