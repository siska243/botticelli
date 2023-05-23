<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TachesRepository::class)]
class Taches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $tache = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?StatusTaches $status = null;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTache(): ?string
    {
        return $this->tache;
    }

    public function setTache(string $tache): self
    {
        $this->tache = $tache;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?StatusTaches
    {
        return $this->status;
    }

    public function setStatus(?StatusTaches $status): self
    {
        $this->status = $status;

        return $this;
    }
}
