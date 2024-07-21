<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'The title cannot be blank.')]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'The author cannot be blank.')]
    private ?string $author = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'The publication year cannot be blank.')]
    #[Assert\Range(min: 1900, max: 2100, notInRangeMessage: 'The publication year must be between {{ min }} and {{ max }}.')]
    private ?int $publicationYear = null;

    #[ORM\Column(type: 'string', length: 13, unique: true)]
    #[Assert\NotBlank(message: 'The ISBN cannot be blank.')]
    #[Assert\Isbn(type: 'isbn13', message: 'The ISBN "{{ value }}" is not a valid ISBN-13.')]
    private ?string $isbn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publicationYear;
    }

    public function setPublicationYear(int $publicationYear): static
    {
        $this->publicationYear = $publicationYear;
        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;
        return $this;
    }
}
