<?php

namespace Framework\Middleware;

class Middleware {
    public static function run(MiddlewareInterface $middleware): void
    {
        $middleware->handle();
    }
}