<?php

namespace App\Entity;

use App\Repository\CandyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CandyRepository::class)]
class Candy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //  les champs ne doivent pas etre vide avant l'insertion en base de données
    #[ORM\Column(length: 255)]
    // #[Assert\Length(min: 10, minMessage: 'La taille minimum pour le champ XXX est de XXX caractères')]
    // #[Assert\NotBlank(message: 'Le champs {{ label }} ne peut pas etre vide')]
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'Le champs {{ label }} ne peut pas etre vide'),
        new Assert\Length(min: 10, minMessage: 'La taille minimum pour le champ {{ label }} est de {{ limit }} caractères')
    ])]
    private string $name = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
