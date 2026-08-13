<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class ErrorController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger
    )
    {
    }

    public function show(FlattenException $exception): Response
    {
        if (null !== $this->logger) {
            $this->logger->error($exception->getMessage());
        }

        return new JsonResponse(['error' => $exception->getMessage(), 'code' => $exception->getStatusCode()]);
    }

    public function error404(): Response
    {
        return new JsonResponse(['code' => 404, 'message' => 'Not found']);
    }

    public function error500(): Response
    {
        return new JsonResponse(['code' => 500, 'message' => 'Internal server error']);
    }

    public function error403(): Response
    {
        return new JsonResponse(['code' => 403, 'message' => 'Forbidden']);
    }

    public function error401(): Response
    {
        return new JsonResponse(['code' => 401, 'message' => 'Unauthorized']);
    }

    public function error400(): Response
    {
        return new JsonResponse(['code' => 400, 'message' => 'Bad request']);
    }
}
