<?php


namespace DrkDD\SchreibMit\Entity;

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
    protected $postalCode;

    /**
     * @var float
     * @ORM\Column(name="longitude", type="float")
     */
    protected $longitude;

    /**
     * @var float
     * @ORM\Column(name="latitude", type="float")
     */
    protected $latitude;

    /**
     * @var Collection|User[]
     * @ORM\OneToMany(targetEntity="User", mappedBy="pflegeheim")
     */
    protected $users;

    /**
     * @return string
     */
    public function getPostalCode(): string
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
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
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
        return $this->postalCode;
    }
}