<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(
 *     schema="Wanted",
 *     name="users",
 *     options={"comment"="A user."},
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UK_username", columns={"username"}),
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="user_id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\Column(name="username", type="string", length=64)
     */
    private string $username;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(name="roles", type="json_array")
     */
    private array $roles;

    public static function createUser(
        UserPasswordEncoderInterface $passwordEncoder,
        string $username,
        string $password
    ): self {
        $self = new self();

        $self->username = $username;
        $self->roles = ['ROLE_USER'];
        $self->password = $passwordEncoder->encodePassword($self, $password);

        return $self;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }
}
