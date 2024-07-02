<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ( !$constraint instanceof PasswordStrength) {
            throw new \InvalidArgumentException(sprintf('Expected instance of %s, got %s',
                PasswordStrength::class, get_class($constraint)));
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (strlen($value) < $constraint::LENGTH_PASSWORD) {
            $this->context->buildViolation($constraint->lengthPasswordMessage)
                ->setParameter('{{ lenPassword }}', (string) strlen($value))
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
