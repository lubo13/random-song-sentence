<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 * @ORM\Table(
 *     indexes={
 *          @ORM\Index(name="search_1", columns={"title"}),
 *          @ORM\Index(name="search_2", columns={"created_at"}),
 *          @ORM\Index(name="search_3", columns={"updated_at"}),
 *          @ORM\Index(name="search_4", columns={"created_at", "updated_at"}),
 *          @ORM\Index(name="search_5", columns={"title","created_at", "updated_at"})
 *     }
 * )
 */
class Song
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $fullTextInThisColumn;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFullTextInThisColumn(): ?string
    {
        return $this->fullTextInThisColumn;
    }

    public function setFullTextInThisColumn(string $fullTextInThisColumn): self
    {
        $this->fullTextInThisColumn = $fullTextInThisColumn;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
