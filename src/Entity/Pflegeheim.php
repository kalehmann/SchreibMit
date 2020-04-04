<?php


namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pflegeheim
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\PflegeHeimRepository")
 */
class Pflegeheim
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255)
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(name="psotal_code", type="string", length=255)
     */
    protected $postalCode;

    /**
     * @var string
     * @ORM\Column(name="street", type="string", length=255)
     */
    protected $street;

    /**
     * @var string
     * @ORM\Column(name="contact_person", type="string", length=255)
     */
    protected $contactPerson;

    /**
     * @var int
     * @ORM\Column(name="max_contacts", type="integer", nullable=false)
     */
    protected $maxContacts;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $longitude;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $latitude;

    /**
     * @var Collection|User[]
     * @ORM\OneToMany(targetEntity="User", mappedBy="pflegeheim")
     */
    protected $users;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param string $contactPerson
     */
    public function setContactPerson(string $contactPerson): void
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     * @return int
     */
    public function getMaxContacts()
    {
        return $this->maxContacts;
    }

    /**
     * @param int $maxContacts
     */
    public function setMaxContacts(int $maxContacts): void
    {
        $this->maxContacts = $maxContacts;
    }

    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User[]|Collection $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    public function __toString()
    {
        return $this->name;
    }
}