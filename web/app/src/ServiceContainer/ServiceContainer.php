<?php

namespace App\Acme\ServiceContainer;


use App\Acme\Controller\ViewController;
use App\Acme\Service\ViewService\ViewService;
use App\Acme\Service\ViewService\ViewStorageInterface;
use App\Acme\Storage\RedisViewStorage;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

class ServiceContainer
{
    private ?ValidatorInterface $validator = null;
    private ?ViewStorageInterface $viewStorage = null;
    private ?ViewService $viewService = null;
    private ?ViewController $viewController = null;

    public function getValidator(): ValidatorInterface
    {
        $this->validator ??= (new ValidatorBuilder())
            ->enableAnnotationMapping(true)
            ->addDefaultDoctrineAnnotationReader()
            ->getValidator()
        ;

        return $this->validator;
    }

    public function getViewStorage(): ViewStorageInterface
    {
        $this->viewStorage ??= new RedisViewStorage(getenv('REDIS_HOST'), getenv('REDIS_PORT'));

        return $this->viewStorage;
    }

    public function getViewService(): ViewService
    {
        $this->viewService ??= new ViewService($this->getViewStorage());

        return $this->viewService;
    }

    public function getViewController(): ViewController
    {
        $this->viewController ??= new ViewController($this->getViewService(), $this->getValidator());

        return $this->viewController;
    }
}
