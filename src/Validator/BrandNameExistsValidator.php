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

    public function validate($value, Constraint $constraint): void
    {
        /* @var BrandNameExists $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $brand = $this->brandRepository->findOneBy([
            'name' => $value
        ]);

        if (! $brand) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
