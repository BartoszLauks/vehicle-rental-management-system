<?php

namespace App\Validator;

use App\Repository\DepotRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DepotNameExistValidator extends ConstraintValidator
{
    public function __construct(
        private readonly DepotRepository $depotRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if ( !$constraint instanceof DepotNameExist) {
            throw new \InvalidArgumentException(sprintf('Expected instance of %s, got %s',
                DepotNameExist::class, get_class($constraint)));
        }

        if (null === $value || '' === $value) {
            return;
        }

        $depot = $this->depotRepository->findOneBy([
           'name' => $value
        ]);

        $exist = (bool) $depot;

        if ($constraint->reverse && !$exist) {
            $this->context->buildViolation($constraint->reverse_message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
            return;
        }

        if (!$exist) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
