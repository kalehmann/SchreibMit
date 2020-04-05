<?php

namespace DrkDD\Pflegefinder\Document;

use DrkDD\Pflegefinder\Validation\ExistingPostalCode;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserDocument
 * @package DrkDD\Pflegefinder\Document
 */
class UserDocument
{
    /**
     * @var string
     * @Assert\NotBlank(message="Der Name darf nciht leer sein")
     */
    public $name;

    /**
     * @var string
     * @Assert\Email(message="Das ist keine valide E-mail-Adresse")
     */
    public $email;

    /**
     * @var string
     * @Assert\Regex("/^\d{5}/", message="Das ist keine valide Postleitzahl")
     * @ExistingPostalCode()
     */
    public $postalCode;

    /**
     * @var string|null
     */
    public $age;
}