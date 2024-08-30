<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BrandNameExists extends Constraint
{
    public string $message = "The brand with name '{{ value }}' not exist.";
    public string $message_reverse = "The brand with name '{{ value }}' exist.";
    public bool $reverse;

    public function __construct(bool $reverse = false, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->reverse = $reverse;
    }
}
