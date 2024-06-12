<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PasswordStrength extends Constraint
{
    public const LENGTH_PASSWORD = 10;

    public string $lengthPasswordMessage = 'The password must have '.self::LENGTH_PASSWORD.' char. Is {{ lenPassword }}';

    public string $oneNumberMessage = "Password must include at least one number!";

    public string $oneCharMessage = "Password must include at least one letter!";
}
