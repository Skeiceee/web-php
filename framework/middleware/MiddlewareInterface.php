<?php

namespace Framework\middleware;


interface MiddlewareInterface
{
    public function handle(): void;
}