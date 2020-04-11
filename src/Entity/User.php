<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package DrkDD\SchreibMit\Entity
 * @ORM\Entity()
 */
class User
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    protected $id = 0;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name = '';

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    protected $email = '';

    /**
     * @var PostalCode
     * @ORM\ManyToOne(targetEntity="PostalCode")
     * @ORM\JoinColumn(name="postal_code", referencedColumnName="postal_code")
     */
    protected $postalCode;

    /**
     * @var int|null
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    protected $age;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="registration_date", type="datetime_immutable", nullable=false)
     */
    protected $registrationDate;

    /**
     * @var null|Pflegeheim
     * @ORM\ManyToOne(targetEntity="Pflegeheim", inversedBy="users")
     * @ORM\JoinColumn(name="pflegeheim_id", referencedColumnName="id", nullable=true)
     */
    protected $pflegeheim;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->registrationDate = new \DateTimeImmutable();
    }

    /**
     * Gibt die Id des Nutzers zurück.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setzt die Id des Nutzers.
     *
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Gibt den Namen oder das Pseudonym des Nutzers zurück.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Setzt den Namen oder das Pseudonym des Nutzers.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gibt die E-Mail Adresse des Nutzers zurück.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Setzt die E-Mail Adresse des Nutzers.
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Gibt die Postleitzahl des Nutzers zurück.
     *
     * @return PostalCode
     */
    public function getPostalCode(): ?PostalCode
    {
        return $this->postalCode;
    }

    /**
     * Setzt die Postleitzahl des Nutzers.
     *
     * @param PostalCode $postalCode
     */
    public function setPostalCode(PostalCode $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Gibt den Schlüssel für die Altersgruppe des Nutzer zurück. Das Mapping erfolgt in der Methode getAltersgruppe.
     *
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Gibt die Altersgruppe des Nutzers menschenlesbar zurück.
     *
     * @return string
     */
    public function getAltersgruppe(): string
    {
        switch ($this->age) {
            case 0:
                return '<6';
            case 1:
                return '6-12';
            case 2:
                return '13-16';
            case 3:
                return '17-27';
            case 4:
                return '>27';
        }

        return 'Unbekannt';
    }

    /**
     * Setzt den Schlüssel für die Altersgruppe des Nutzers. Das Mapping erfolgt in der Methode getAltersgruppe.
     *
     * @param int|null $age
     */
    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    /**
     * Gibt den Zeitpunkt der Registrierung des Nutzers zurück.
     *
     * @return \DateTimeImmutable
     */
    public function getRegistrationDate(): \DateTimeImmutable
    {
        return $this->registrationDate;
    }

    /**
     * Setzt den Zeitpunkt der Registrierung des Nutzers.
     *
     * @param \DateTimeImmutable $registrationDate
     */
    public function setRegistrationDate(\DateTimeImmutable $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * Gibt das dem Nutzer zugewiesen Pflegeheim zurück.
     *
     * @return Pflegeheim|null
     */
    public function getPflegeheim(): ?Pflegeheim
    {
        return $this->pflegeheim;
    }

    /**
     * Setzt das dem Nutzer zugewiesene Pflegeheim.
     *
     * @param Pflegeheim|null $pflegeheim
     */
    public function setPflegeheim(?Pflegeheim $pflegeheim): void
    {
        $this->pflegeheim = $pflegeheim;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}