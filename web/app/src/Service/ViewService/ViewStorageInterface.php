<?php

namespace App\Acme\Service\ViewService;

interface ViewStorageInterface
{
    public function increase(string $countryCode): void;
    public function getAll(): array;
}
