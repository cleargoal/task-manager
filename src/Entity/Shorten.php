<?php

namespace App\Entity;

use App\Repository\ShortenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShortenRepository::class)]
class Shorten
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $source_url = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $hashed_url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceUrl(): ?string
    {
        return $this->source_url;
    }

    public function setSourceUrl(string $source_url): self
    {
        $this->source_url = $source_url;

        return $this;
    }

    public function getHashedUrl(): ?string
    {
        return $this->hashed_url;
    }

    public function setHashedUrl(string $hashed_url): self
    {
        $this->hashed_url = $hashed_url;

        return $this;
    }
}
