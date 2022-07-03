<?php

namespace App\Acme;

use App\Acme\ServiceContainer\ServiceContainer;
use Redis;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    public function handleHttpRequest(Request $request): Response
    {
        $container = new ServiceContainer();

        $path = $request->getPathInfo();
        $method = $request->getMethod();

        if ($path === '/views' && $method == 'POST') {
            return $container->getViewController()->post($request);
        }
        if ($path === '/views' && $method == 'GET') {
            return $container->getViewController()->get();
        }

        return new Response('Not Found', Response::HTTP_NOT_FOUND);
    }
}
