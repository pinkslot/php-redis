<?php

namespace App\Acme\Controller;

use App\Acme\Service\ViewService\Exception\StorageException;
use App\Acme\Service\ViewService\Input\IncreaseViews;
use App\Acme\Service\ViewService\ViewService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class ViewController
{
    private ViewService $viewService;
    private ValidatorInterface $validator;

    public function __construct(ViewService $viewService, ValidatorInterface $validator)
    {
        $this->viewService = $viewService;
        $this->validator = $validator;
    }

    public function post(Request $request): Response
    {
            $requestContent = json_decode($request->getContent(), true);

            $input = new IncreaseViews($requestContent['country'] ?? null);
            $errors = $this->validator->validate($input);

            if (count($errors) > 0) {
                return new JsonResponse(array_map(
                    function (ConstraintViolationInterface $error) {
                        return "{$error->getPropertyPath()}: {$error->getMessage()}";
                    }
                    , iterator_to_array($errors)));
            }

        try {
            $this->viewService->increase($input);
        } catch (Throwable $exception) {
            return new JsonResponse('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    public function get(): Response
    {
        try {
            return new JsonResponse($this->viewService->getAll());
        } catch (Throwable $exception) {
            return new JsonResponse('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
