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

    public function validate(mixed $value, Constraint $constraint): void
    {
        if ( !$constraint instanceof EmailUse) {
            throw new \InvalidArgumentException(sprintf('Expected instance of %s, got %s',
                EmailUse::class, get_class($constraint)));
        }

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
