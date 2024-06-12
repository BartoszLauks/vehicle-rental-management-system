<?php

namespace App\Generator;

class StringGenerator
{
    private const DEFAULT_LENGTH = 10;

    private const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function generate(int $length = self::DEFAULT_LENGTH): string
    {
        $string = '';
        $charactersLen = strlen(self::CHARACTERS);

        while ($length > 0) {
            $string .= self::CHARACTERS[rand(0, $charactersLen - 1)];
            $length--;
        }

        return $string;
    }
}