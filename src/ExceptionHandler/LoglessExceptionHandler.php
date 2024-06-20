<?php

declare(strict_types=1);

namespace App\ExceptionHandler;

use App\Exception\LoglessException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class LoglessExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(ExceptionEvent $event): void
    {
        /** @var ValidationException $exception */
        $exception = $event->getThrowable();

        $customResponse = new JsonResponse(data: [
            'message' => $exception->getMessage(),
        ], status: $exception->getCode());

        $event->setResponse($customResponse);
    }

    public function supports(\Throwable $throwable): bool
    {
        return $throwable::class == LoglessException::class;
    }

    public function getPriority(): int
    {
        return 0;
    }
}
