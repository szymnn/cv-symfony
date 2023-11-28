<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api/auth/user/self')]
#[Security(name: 'Bearer')]
class UserController extends AbstractController
{
    #[Route( name: 'edit-user-data', methods: ['PUT'])]

    #[OA\Put(
        operationId: 'user-edit',
        summary: 'Edit',
        tags: ['User'],

    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                    ),
                ])
            ),
        ]
    )]

    public function edit(Request $request, UserInterface $user)
    {
       var_dump($user);
       die();
    }
}
