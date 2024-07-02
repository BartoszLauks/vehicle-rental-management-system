<?php

namespace App\Updater;

class AbstractUpdater
{
    protected function updateField(object $object,/* string $field,*/ mixed $newValue, string $getter, string $setter): void
    {
        if ($newValue && $newValue !== $object->{$getter}()) {
            $object->{$setter}($newValue);
        }
    }

    protected function putField(object $object, mixed $newValue, string $setter): void
    {
        $object->{$setter}($newValue);
    }
}