<?php

namespace DrkDD\SchreibMit\Document;

use DrkDD\SchreibMit\Validation\ExistingPostalCode;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserDocument
 * @package DrkDD\SchreibMit\Document
 */
class UserDocument
{
    /**
     * @var string
     * @Assert\NotBlank(message="Der Name darf nicht leer sein")
     */
    public $name;

    /**
     * @var string
     * @Assert\Email(message="Das ist keine valide E-mail-Adresse")
     */
    public $email;

    /**
     * @var string
     * @ExistingPostalCode()
     * @Assert\Regex(pattern="/^\d{5}/", htmlPattern="\d{5}", message="Das ist keine valide Postleitzahl")
     */
    public $postalCode;

    /**
     * @var int|null
     */
    public $age;
}