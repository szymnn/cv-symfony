<?php

namespace App\Service;

use App\Dto\AuthorizationDto;
use App\Entity\User;
use App\Validator\UserValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
       private readonly UserPasswordHasherInterface $passwordEncoder,
       private readonly EntityManagerInterface $entityManager,
       private readonly UserValidator $validator,
    ){
    }

    public function store(AuthorizationDto $dto)
    {
        $this->validator->validate($dto->email);

        $user = new User();
        $user->setEmail($dto->email);
        $password = $this->hashPasssword($dto->password,$user);
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse( ["message" => "Registration successfully"]);
    }

    public function hashPasssword(string $password, User $user)
    {
        $pass = $this->passwordEncoder->hashPassword($user, $password);
        return $pass;
    }
}