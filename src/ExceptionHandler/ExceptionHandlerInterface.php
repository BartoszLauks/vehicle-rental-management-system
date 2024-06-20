<?php

namespace App\ExceptionHandler;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AutoconfigureTag('app.exception_handler')]
interface ExceptionHandlerInterface
{
    public function handle(ExceptionEvent $event): void;

    public function supports(\Throwable $throwable): bool;

    public function getPriority(): int;

}
