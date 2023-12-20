<?php

namespace App\Controller;

use App\Dto\ContributorsDto;
use App\Repository\ContributorsRepository;
use App\Service\ContributorsService;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api/auth/user/contributors')]
#[Security(name: 'Bearer')]
class ContributorController extends AbstractController
{

    public function __construct(
        private readonly ContributorsService $service,
    ){
    }

    #[Route('', name: 'contributor-register', methods: ['POST'])]

    #[OA\Post(
        operationId: 'contributor-create',
        summary: 'Create new Contributor',
        tags: ['Contributors'],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'John'
                    ),
                    new OA\Property(
                        property: 'lastname',
                        type: 'string',
                        example: 'Doe'
                    ),
                    new OA\Property(
                        property: 'individual',
                        type: 'boolean',
                        example: 'true'
                    ),
                ])
            ),
        ]
    )]
    public function store(#[MapRequestPayload] ContributorsDto $dto)
    {
        $user = $this->getUser();
        return $this->service->store($dto,$user);
    }

    #[Route('/{id}', name: 'contributor-patch', methods: ['PATCH'])]

    #[OA\Patch(
        operationId: 'contributor-edit',
        summary: 'Edit a Contributor ',
        tags: ['Contributors'],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'John'
                    ),
                    new OA\Property(
                        property: 'lastname',
                        type: 'string',
                        example: 'Doe'
                    ),
                    new OA\Property(
                        property: 'individual',
                        type: 'boolean',
                        example: 'true'
                    ),
                ])
            ),
        ]
    )]
    public function patch(Request $request, #[MapRequestPayload] ContributorsDto $dto)
    {
        $id = $request->get('id');
        return $this->service->patch($dto,$this->getUser(),$id);
    }

    #[Route('/{id}', name: 'contributor-get', methods: ['GET'])]

    #[OA\Get(
        operationId: 'contributor-get',
        summary: 'Get One Contributor',
        tags: ['Contributors'],
    )]
    public function getOne(Request $request)
    {
        $id = $request->get('id');
        return $this->service->get($this->getUser(),$id);
    }

    #[Route('', name: 'contributors-get', methods: ['GET'])]

    #[OA\Get(
        operationId: 'contributors-get',
        summary: 'Get Contributors',
        tags: ['Contributors'],
    )]
    public function get()
    {
        return $this->service->get($this->getUser());
    }

    #[Route('/{id}', name: 'contributor-delete', methods: ['DELETE'])]

    #[OA\Delete(
        operationId: 'contributors-delete',
        summary: 'Delete Contributors',
        tags: ['Contributors'],
    )]
    public function delete(Request $request)
    {
        $id = $request->get('id');
        return $this->service->delete($id,$this->getUser());
    }

}
