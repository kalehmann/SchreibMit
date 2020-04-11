<?php
declare(strict_types=1);

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
    protected $username = '';

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password = '';

    /**
     * Gibt den Nutzernamen des Admins zurück.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Setzt den Nutzernamen des Admins.
     *
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Diese Methode ist nur zur Erfüllung des UserInterfaces implementiert. Durch die Verwendung von bcrypt wird das
     * Salt mit im Hash (Passwortfeld) gespeichert
     *
     * @return string
     */
    public function getSalt(): string
    {
        return '';
    }

    /**
     * Gibt die Rollen des Admins zurück.
     *
     * @return array|string[]
     */
    public function getRoles(): array
    {
        return [
            'ROLE_ADMIN',
        ];
    }

    /**
     * Gibt das mit bcrypt gehashte Paswort des Admins zurück.
     *
     * @return string|null
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Setzt das Passwort des Admins.
     *
     * @param string $password der bcrypt Hash des Passwortes
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Nicht in Verwendung, nur zur Erfüllung des UserInterface implementiert.
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * Getter für das Klartextpasswort des Admins. Gibt immer einen leeren String zurück.
     *
     * @return string
     */
    public function getPlainPassword(): string
    {
        return '';
    }

    /**
     * Hashed das Klartextpasswort mittels bcrypt und speichert es am Admin.
     *
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->username;
    }
}