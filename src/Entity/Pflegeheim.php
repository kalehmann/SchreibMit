<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pflegeheim
 * @package DrkDD\SchreibMit\Entity
 *
 * @ORM\Entity(repositoryClass="DrkDD\SchreibMit\Repository\PflegeHeimRepository")
 */
class Pflegeheim
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    protected $id = 0;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name = '';

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255)
     */
    protected $city = '';

    /**
     * @var string
     * @ORM\Column(name="psotal_code", type="string", length=255)
     */
    protected $postalCode = '';

    /**
     * @var string
     * @ORM\Column(name="street", type="string", length=255)
     */
    protected $street = '';

    /**
     * @var string
     * @ORM\Column(name="contact_person", type="string", length=255)
     */
    protected $contactPerson = '';

    /**
     * @var int
     * @ORM\Column(name="max_contacts", type="integer", nullable=false)
     */
    protected $maxContacts = 10;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $longitude = 0.0;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $latitude = 0.0;

    /**
     * @var Collection|User[]
     * @ORM\OneToMany(targetEntity="User", mappedBy="pflegeheim")
     */
    protected $users;

    /**
     * Pflegeheim constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Gibt die Id des Pflegeheims zurück.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setzt die Id des Pflegeheims.
     *
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Gibt den Namen des Pflegeheims zurück.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Setzt den Namen des Pflegeheims.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gibt den Längengrad des Pflegeheims zurück.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Setzt den Längengrad des Pflegeheims.
     *
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Gibt den Breitengrad des Pflegeheims zurück.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Setzt den Breitengrad des Pflegeheims.
     *
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Gibt die Stadt des Pflegeheims zurück.
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Setzt die Stadt des Pflegeheims.
     *
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Gibt die Postleitzahl des Pflegeheims zurück.
     *
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Setzt die Postleitzahl des Pflegeheims.
     *
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Gibt die Straße und Hausnummer des Pflegeheims zurück.
     *
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * Setzt Straße und Hausnummer des Pflegeheims.
     *
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * Gibt die Kontaktperson des Pflegeheims zurück.
     *
     * @return string
     */
    public function getContactPerson(): string
    {
        return $this->contactPerson;
    }

    /**
     * Setzt die Kontaktperson des Pflegeheims.
     *
     * @param string $contactPerson
     */
    public function setContactPerson(string $contactPerson): void
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     * Gibt die maximale Anzahl an Nutzern, die an das Pflegeheim vermittelt werden können zurück.
     *
     * @return int
     */
    public function getMaxContacts(): int
    {
        return $this->maxContacts;
    }

    /**
     * Setzt die maximale Anzahl an Nutzer, die an das Pflegeheim vermittelt werden können.
     *
     * @param int $maxContacts
     */
    public function setMaxContacts(int $maxContacts): void
    {
        $this->maxContacts = $maxContacts;
    }

    /**
     * Gibt alle an das Pflegeheim vermittelte Nutzer zurück.
     *
     * @return User[]|Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * Setzt die an das Pflegeheim vermittelten Nutzer.
     *
     * @param User[]|Collection $users
     */
    public function setUsers(Collection $users): void
    {
        $this->users = $users;
    }

    /**
     * Gibt die Anzahl der an das Pflegeheim vermittelten Nutzer zurück.
     *
     * @return int
     */
    public function getVermittelteKontakte(): int
    {
        return count($this->users);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}