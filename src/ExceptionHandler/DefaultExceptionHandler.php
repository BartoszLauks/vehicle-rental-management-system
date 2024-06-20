<?php

declare(strict_types=1);

namespace App\ExceptionHandler;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class DefaultExceptionHandler implements ExceptionHandlerInterface
{
    public function __construct(
        private LoggerInterface $errorLogger
    ) {
    }

    public function handle(ExceptionEvent $event): void
    {
        $this->errorLogger->error($event->getThrowable()->getMessage());
        $exception = $event->getThrowable();

        $code = $exception->getPrevious()?->getCode();
        $message['message'] = $exception->getMessage();

        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        }

        if (! $code || $code < 400) {
            $code = $exception->getCode() !== 0 ? $exception->getCode() : 500;
        }

        if ($code >= 500) {
            $message['message'] = 'Something went wrong';
        }

        $customResponse = new JsonResponse(data: $message, status: (int) $code);

        $event->setResponse($customResponse);
    }

    public function supports(\Throwable $throwable): bool
    {
        return true;
    }

    public function getPriority(): int
    {
        return 100;
    }
}
