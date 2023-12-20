<?php

namespace App\Entity;

use App\Repository\ContributorsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContributorsRepository::class)]
class Contributors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('Contributor')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contributors')]
    #[Groups('UserInfo')]
    private ?user $client = null;

    #[ORM\Column(length: 255)]
    #[Groups('Contributor')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('Contributor')]
    private ?string $lastname = null;

    #[ORM\Column]
    #[Groups('Contributor')]
    private ?bool $individual = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?user
    {
        return $this->client;
    }

    public function setClient(?user $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isIndividual(): ?bool
    {
        return $this->individual;
    }

    public function setIndividual(bool $individual): static
    {
        $this->individual = $individual;

        return $this;
    }

//    public function __toString(): string
//    {
//        return new JsonResponse(
//            [
//                "Name"=>$this->getName(),
//                "LastName"=>$this->getLastname(),
//                "Client"=>$this->getClient(),
//                "Individual"=>$this->isIndividual()
//            ]);
//        // TODO: Implement __toString() method.
//    }
}
