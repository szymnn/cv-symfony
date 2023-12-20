<?php

namespace App\Service;

use App\Dto\ContributorsDto;
use App\Entity\Contributors;
use App\Entity\User;
use App\Repository\ContributorsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ContributorsService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ContributorsRepository $repository,
        private readonly SerializerInterface $serializer,
    ){
    }

    /**
     * @param ContributorsDto $dto
     * @param User $user
     * @return JsonResponse
     */
    public function store(ContributorsDto $dto, User $user){
        $contributor = new Contributors();
        $contributor->setClient($user);
        $contributor->setName($dto->name);
        $contributor->setLastname($dto->lastname);
        $contributor->setIndividual($dto->individual);
        $this->entityManager->persist($contributor);
        $this->entityManager->flush();

        return new JsonResponse( ["message" => "Successfully created new contributor"]);
    }

    /**
     * @param ContributorsDto $contributorsDto
     * @param User $user
     * @param int $id
     * @return JsonResponse
     */
    public function patch(ContributorsDto $contributorsDto, User $user, int $id)
    {
        $contributor = $this->getContributors($user,$id);

        if(!$contributor){
            return new JsonResponse(["message" => "Contributor(s) not found"]);
        }

        $contributor->setName($contributorsDto->name);
        $contributor->setLastname($contributorsDto->lastname);
        $contributor->setIndividual($contributorsDto->individual);
        $this->entityManager->flush();

        return new JsonResponse( ["message" => sprintf("Contributor ID: %s successfully updated ",$id)]);
    }

    /**
     * @param User $user
     * @param int|null $id
     * @return JsonResponse
     */
    public function delete(User $user, int $id=null)
    {
        $contributor = $this->getContributors($user,$id);

        if(!$contributor){
            return new JsonResponse(["message" => "Contributor(s) not found"]);
        }

        $this->entityManager->remove($contributor);
        $this->entityManager->flush();

        return new JsonResponse( ["message" => sprintf("Contributor ID: %s successfully updated ",$id)]);
    }

    /**
     * @param User $user
     * @param int|null $id
     * @return JsonResponse|Response
     */
    public function get( User $user,int $id=null)
    {
        $contributor = $this->getContributors($user,$id);

        if(!$contributor){
            return new JsonResponse(["message" => "Contributor(s) not found"]);
        }

        $response = $this->serializer->serialize($contributor, 'json',
            [
                'groups' => [
                    'UserInfo',
                    'Contributor',
                    'UserRoles'
                ]
            ]);
        return new Response($response);
    }

    /**
     * @param User $user
     * @param int|null $id
     * @return Contributors|Contributors[]|null
     */
    private function getContributors( User $user,int $id=null)
    {
        if(!$id){
            return $this->repository->findBy(
                [
                    'client'=>$user
                ]
            );
        }

        return $this->repository->findOneBy(
            [
                'id'=>$id,
                'client'=>$user
            ]
        );
    }
}