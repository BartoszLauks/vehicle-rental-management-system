<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var PasswordStrength $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (strlen($value) < $constraint::LENGTH_PASSWORD) {
            $this->context->buildViolation($constraint->lengthPasswordMessage)
                ->setParameter('{{ lenPassword }}', strlen($value))
                ->addViolation();
        }

        if (!preg_match('#[0-9]+#', $value)) {
            $this->context->buildViolation($constraint->oneNumberMessage)
                ->addViolation();
        }

        if (!preg_match('#[a-zA-Z]+#', $value)) {
            $this->context->buildViolation($constraint->oneCharMessage)
                ->addViolation();
        }
//        $this->context->buildViolation($constraint->message)
//            ->setParameter('{{ value }}', $value)
//            ->addViolation();
    }
}
