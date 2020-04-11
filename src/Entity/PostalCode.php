<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostalCode
 * @package DrkDD\SchreibMit\Entity
 *
 * @ORM\Entity()
 */
class PostalCode
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="postal_code", type="string", length=5)
     */
    protected $postalCode = '';

    /**
     * @var float
     * @ORM\Column(name="longitude", type="float")
     */
    protected $longitude = 0.0;

    /**
     * @var float
     * @ORM\Column(name="latitude", type="float")
     */
    protected $latitude = 0.0;

    /**
     * @var Collection|User[]
     * @ORM\OneToMany(targetEntity="User", mappedBy="pflegeheim")
     */
    protected $users;

    /**
     * PostalCode constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Gibt die Postleitzahl zurück.
     *
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Setzt die Postleitzahl.
     *
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Gibt den Längengrad des Postleitzahlenbereiches zurück.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Setzt den Längengrad des Postleitzahlenbereiches.
     *
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Gibt den Breitengrad des Postleitzahlenbereiches zurück.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Setzt den Breitengrad des Postleitzahlenbereiches.
     *
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Gibt alle Nutzer mit dieser Postleitzahl zurück.
     *
     * @return User[]|Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * Setzt die Nutzer mit dieser Postleitzahl.
     *
     * @param User[]|Collection $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    public function __toString(): string
    {
        return $this->postalCode;
    }
}