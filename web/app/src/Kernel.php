<?php

namespace App\Acme;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function handleHttpRequest(Request $request): Response
    {
        return new Response('Hello');
    }
}
