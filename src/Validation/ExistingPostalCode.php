<?php

namespace DrkDD\SchreibMit\Validation;


use Symfony\Component\Validator\Constraint;

/**
 * Class ExistingPostalCode
 * @Annotation
 */
class ExistingPostalCode extends Constraint
{
    /**
     * @var string
     */
    public $message = 'postal_code.not_found';

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return [
            self::PROPERTY_CONSTRAINT,
        ];
    }
}