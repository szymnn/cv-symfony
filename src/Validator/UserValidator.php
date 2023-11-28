<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidator;

class UserValidator extends ConstraintValidator
{
    public function __construct(
        public readonly UserRepository $repository
    ){
    }

    public function validate($value, Constraint $constraint = new NotBlank())
    {

        /* @var App\Validator\User $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $data = $this->repository->findOneBy(['email'=>$value]);
        if(!empty($data)){
            throw new \Exception("An email address is already registered");
        }

    }
}
