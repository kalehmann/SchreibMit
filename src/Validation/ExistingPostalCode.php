<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Validation;

use Symfony\Component\Validator\Constraint;

/**
 * Class ExistingPostalCode
 * @package DrkDD\SchreibMit\Validation
 * @Annotation
 */
class ExistingPostalCode extends Constraint
{
    /** @var string */
    public $message = 'postal_code.not_found';

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return [
            self::PROPERTY_CONSTRAINT,
        ];
    }
}