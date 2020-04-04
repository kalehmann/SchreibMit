<?php

namespace DrkDD\Pflegefinder\Validation;

use DrkDD\Pflegefinder\Entity\PostalCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ExistingPostalCodeValidator
 * @package DrkDD\Pflegefinder\Validation
 */
class ExistingPostalCodeValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param string $postalCode
     * @param ExistingPostalCode $constraint
     */
    public function validate($postalCode, Constraint $constraint)
    {
        $postalCodeRepo = $this->entityManager->getRepository(PostalCode::class);
        $postalCodeEntity = $postalCodeRepo->find($postalCode);

        if ($postalCodeEntity) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}