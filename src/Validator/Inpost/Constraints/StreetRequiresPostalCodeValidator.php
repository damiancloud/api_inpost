<?php
namespace App\Validator\Inpost\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class StreetRequiresPostalCodeValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     * 
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof StreetRequiresPostalCode) {
            throw new UnexpectedTypeException($constraint, StreetRequiresPostalCode::class);
        }

        $postalCodeValue = $this->context->getRoot()->get('postal_code')->getData();
        if ($value && empty($postalCodeValue)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('postal_code')
                ->addViolation();
        }
    }
}