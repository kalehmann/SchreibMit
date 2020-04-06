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
    public $message = "Die Postleitzahl wurde im System nicht gefunden";

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