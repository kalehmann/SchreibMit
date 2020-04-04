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
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     * @Assert\Regex("/^\d{5}/")
     * @ExistingPostalCode()
     */
    public $postalCode;

    /**
     * @var string|null
     */
    public $age;
}