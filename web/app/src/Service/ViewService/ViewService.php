<?php

namespace App\Acme\Service\ViewService;

use App\Acme\Service\ViewService\Input\IncreaseViews;
use App\Acme\Service\ViewService\ViewStorageInterface;

class ViewService
{
    private ViewStorageInterface $viewStorage;

    public function __construct(
        ViewStorageInterface $viewStorage
    ) {
        $this->viewStorage = $viewStorage;
    }

    public function increase(IncreaseViews $increaseViews): void
    {
        $this->viewStorage->increase($increaseViews->getCountry());
    }

    public function getAll(): array
    {
        return $this->viewStorage->getAll();
    }
}
