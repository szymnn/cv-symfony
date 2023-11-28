<?php

namespace App\Controller;


use App\Dto\AuthorizationDto;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use OpenApi\Attributes as OA;


#[Route('/api')]
class AuthenticationController extends AbstractController
{

    public function __construct(
        private readonly UserService $service
    ){
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    #[OA\Post(
        operationId: 'user-register',
        summary: 'Register',
        tags: ['Authorization'],

    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'm@m.pl'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        example: '123456S'
                    ),
                ])
            ),
        ]
    )]
    public function register(#[MapRequestPayload] AuthorizationDto $dto): Response
    {
        try {
            $user = $this->service->store($dto);
            return $user;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
