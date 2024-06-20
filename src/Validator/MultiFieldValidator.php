<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class MultiFieldValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    public function validate(mixed $value, array $groups): void
    {
        $validations = $this->validator->validate($value, null, $groups);
        $errors = [];

        if ($validations->count() > 0) {
            foreach ($validations as $validation) {
                $errors[$validation->getPropertyPath()][] = $validation->getMessage();
            }
        }
        
        if (! empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}