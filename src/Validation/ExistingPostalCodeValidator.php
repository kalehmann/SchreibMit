<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Validation;

use DrkDD\SchreibMit\Entity\PostalCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ExistingPostalCodeValidator
 * @package DrkDD\SchreibMit\Validation
 */
class ExistingPostalCodeValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * ExistingPostalCodeValidator constructor.
     * @param EntityManagerInterface $em
     * @param TranslatorInterface    $translator
     */
    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->entityManager = $em;
        $this->translator = $translator;
    }

    /**
     * @param string             $postalCode
     * @param ExistingPostalCode $constraint
     */
    public function validate($postalCode, Constraint $constraint): void
    {
        $postalCodeRepo = $this->entityManager->getRepository(PostalCode::class);
        $postalCodeEntity = $postalCodeRepo->find($postalCode);

        if ($postalCodeEntity) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}