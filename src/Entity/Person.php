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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Groups({"search"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Groups({"search"})
     */
    private $lastname;

    /**
     * @ORM\Column(name="is_wanted", type="boolean")
     */
    private $isWanted = false;

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

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(string $first_name): self
    {
        $this->firstname = $first_name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isWanted(): ?bool
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
}
