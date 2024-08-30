<?php

namespace App\Validator;

use App\Repository\BrandRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BrandNameExistsValidator extends ConstraintValidator
{
    public function __construct(
      private readonly BrandRepository $brandRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if ( !$constraint instanceof BrandNameExists) {
            throw new \InvalidArgumentException(sprintf('Expected instance of %s, got %s',
                BrandNameExists::class, get_class($constraint)));
        }

        if (null === $value || '' === $value) {
            return;
        }


        $brand = $this->brandRepository->findOneBy([
            'name' => $value
        ]);

        $exist = (bool) $brand;

        if ($constraint->reverse && !$exist) {
            $this->context->buildViolation($constraint->message_reverse)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        if ( !$exist) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
