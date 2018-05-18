<?php

namespace LivingstonFC\Middleware;

class FileMove
{
    public function __invoke($request, $response, $next)
    {


       $response = $next($request, $response);

       return $response;
    }
}
?>
