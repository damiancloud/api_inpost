<?php

//TODO dodanie do recources na sztywno wpisanego type - points!

namespace App\Entity\Inpost;

use App\Repository\Inpost\ResourcesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourcesRepository::class)]
class Resources
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $count = null;

    #[ORM\Column]
    private ?int $page = null;

    #[ORM\Column]
    private ?int $totalPages = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column]
    private ?string $queryValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getTotalPages(): ?int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): static
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getQueryValue(): ?string
    {
        return $this->queryValue;
    }

    public function setQueryValue(string $queryValue): static
    {
        $this->queryValue = $queryValue;

        return $this;
    }
}
