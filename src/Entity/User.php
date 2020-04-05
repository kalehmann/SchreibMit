<?php


namespace DrkDD\Pflegefinder\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package DrkDD\Pflegefinder\Entity
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
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    protected $email;

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

    public function __construct()
    {
        $this->registrationDate = new \DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return PostalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param PostalCode $postalCode
     */
    public function setPostalCode(PostalCode $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getAltersGruppe(): string
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
     * @param int|null $age
     */
    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getRegistrationDate(): \DateTimeImmutable
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTimeImmutable $registrationDate
     */
    public function setRegistrationDate(\DateTimeImmutable $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return Pflegeheim|null
     */
    public function getPflegeheim(): ?Pflegeheim
    {
        return $this->pflegeheim;
    }

    /**
     * @param Pflegeheim|null $pflegeheim
     */
    public function setPflegeheim(?Pflegeheim $pflegeheim): void
    {
        $this->pflegeheim = $pflegeheim;
    }

    public function __toString()
    {
        return $this->email;
    }
}