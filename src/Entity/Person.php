<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table(
 *     schema="Wanted",
 *     name="persons",
 *     options={"comment"="A person."},
 * )
 *
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Column(name="person_id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"search"})
     */
    private ?int $id;

    /**
     * @ORM\Column(name="full_name", type="string", length=255)
     *
     * @JMS\Groups({"search"})
     */
    private string $fullName;

    /**
     * @ORM\Column(name="is_wanted", type="boolean")
     */
    private bool $isWanted = false;

    /**
     * @ORM\Column(name="date_of_birth", type="date", nullable=true)
     *
     * @JMS\Groups({"search"})
     */
    private ?\DateTimeInterface $dateOfBirth;

    /**
     * @ORM\Column(name="created_date", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeInterface $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsWanted(): ?bool
    {
        return $this->isWanted;
    }

    public function setIsWanted(bool $isWanted): self
    {
        $this->isWanted = $isWanted;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

}
