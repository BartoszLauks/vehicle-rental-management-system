<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class DepotNameExist extends Constraint
{
    public string $reverse_message = "The Depot with name '{{ value }}' exist.";
    public string $message = "The Depot with name '{{ value }}' not exist.";
    public bool $reverse;

    public function __construct(bool $reverse = false, ?string $message = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->reverse = $reverse;
    }
}
