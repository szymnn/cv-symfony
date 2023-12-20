<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
class ContributorsDto
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?string $name,

        public readonly ?string $lastname,

        #[Assert\NotBlank]
        public readonly ?bool $individual,
    )
    {
    }
}