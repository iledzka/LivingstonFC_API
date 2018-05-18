<?php

namespace LivingstonFC\Middleware;

// Add to POST requests
class ParamValidation
{
    public function __invoke($request, $response, $next)
    {
       $params = $request->getParsedBody();

       foreach ($params as $key => $param){
         error_log('param: '.$param.' - end of param');
         if (empty($param)){
           return $response->withStatus(400);
         }
       }

       $response = $next($request, $response);

       return $response;
    }
}
?>
