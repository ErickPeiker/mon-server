<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

if (!function_exists('abort')) {
    function abort($code, $message = '', array $headers = [])
    {
        throw new HttpException($code, $message, null, $headers);
    }
}

if (!function_exists('abortIf')) {
    function abortIf($boolean, $code, $message = '', array $headers = [])
    {
        if ($boolean) {
            abort($code, $message, $headers);
        }
    }
}
