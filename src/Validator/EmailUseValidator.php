<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailUseValidator extends ConstraintValidator
{
    public function __construct(
      private readonly UserRepository $userRepository,
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        /* @var EmailUse $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $value]);

        if ($user) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
