<?php

namespace App\Document;

use App\Validation\ExistingPostalCode;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserDocument
 * @package App\Document
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