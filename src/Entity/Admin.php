<?php


namespace DrkDD\SchreibMit\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Admin
 * @package DrkDD\SchreibMit\Entity
 * @ORM\Entity()
 */
class Admin implements UserInterface
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="username", type="string", length=255, nullable=false, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return '';
    }

    /**
     * @return array|string[]
     */
    public function getRoles()
    {
        return [
            'ROLE_ADMIN',
        ];
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     *
     */
    public function eraseCredentials(): void
    {
        $this->password = '';
    }

    public function getPlainPassword(): string
    {
        return '';
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function __toString()
    {
        return $this->username;
    }
}