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
     * @Assert\NotBlank(message="user.name.not_empty")
     */
    public $name;

    /**
     * @var string
     * @Assert\Email(message="user.email.not_valid")
     */
    public $email;

    /**
     * @var string
     * @ExistingPostalCode()
     * @Assert\Regex(pattern="/^\d{5}/", htmlPattern="\d{5}", message="user.postal_code.not_valid")
     */
    public $postalCode;

    /**
     * @var int|null
     */
    public $age;
}