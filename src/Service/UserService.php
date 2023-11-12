<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function store(object $params, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $user = new User();
        $user->setEmail($params->email);
        $password = $passwordEncoder->hashPassword($user, $params->password);
        $user->setPassword($password);

        $this->getValidation($user, $validator);
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response("Registration successfully");
    }
    public function getValidation(User $user, ValidatorInterface $validator)
    {
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                throw new \Exception(json_encode([
                        "field "=>$error->getPropertyPath(),
                        "message"=>$error->getMessage()
                    ])
                );
            }
        }
        return true;
    }
}