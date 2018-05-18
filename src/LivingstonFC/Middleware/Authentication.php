<?php

namespace LivingstonFC\Middleware;

use LivingstonFC\Models\User;
use LivingstonFC\Models\Admin;
use LivingstonFC\Models\Person;
use LivingstonFC\Models\Token;

class Authentication
{
    public function __invoke($request, $response, $next)
    {
      switch ($request->getUri()->getPath()){
        case 'register':
          break;
        case 'login':
        $auth = $request->getHeader('Authorization');

        $_apikey = $auth[0];

        $apikey = substr($_apikey, strpos($_apikey, ' ') + 1);

        $user = new User();
        $admin = new Admin();
        $token = new Token();

        if ($admin->authenticate($apikey)){
          $matchAdminToKey = Admin::where('username', '=', $request->getHeader('username'));
          if ($matchAdminToKey){
            break;
          }
        } elseif ($user->authenticate($apikey)) {
          $matchUserToKey = User::where('username', '=', $request->getHeader('username'));
          if ($matchUserToKey){
            break;
          }
        }
        return $response->withStatus(401);
          break;
        case 'fullmembership':
        $auth = $request->getHeader('Authorization');
        $access_token = $request->getHeader('Access_token');
        $_apikey = $auth[0];
        $apikey = substr($_apikey, strpos($_apikey, ' ') + 1);

        $admin = new Admin();
        $token = new Token();
        if (!$admin->authenticate($apikey) || !$token->isValidAdminToken($access_token[0])){
          return $response->withStatus(401);
        }
        break;
        case 'partialmembership':
        $auth = $request->getHeader('Authorization');
        $access_token = $request->getHeader('Access_token');
        $_apikey = $auth[0];
        $apikey = substr($_apikey, strpos($_apikey, ' ') + 1);

        $admin = new Admin();
        $token = new Token();

        if (!$admin->authenticate($apikey) || !$token->isValidAdminToken($access_token[0])){
          return $response->withStatus(401);
        }
        break;
        case 'user':
        $auth = $request->getHeader('Authorization');
        $access_token = $request->getHeader('Access_token');
        $_apikey = $auth[0];
        $apikey = substr($_apikey, strpos($_apikey, ' ') + 1);

        $admin = new Admin();
        $token = new Token();

        if (!$admin->authenticate($apikey) || !$token->isValidAdminToken($access_token[0])){
          return $response->withStatus(401);
        }
        break;
        default:
         $auth = $request->getHeader('Authorization');
         $access_token = $request->getHeader('Access_token');
         $_apikey = $auth[0];
         $apikey = substr($_apikey, strpos($_apikey, ' ') + 1);

         $user = new User();
         $admin = new Admin();
         $token = new Token();

         if ($admin->authenticate($apikey)){
           if (!$token->isValidAdminToken($access_token[0])){
             return $response->withStatus(401);
           }
         }
         if ($user->authenticate($apikey)){
           if (!$token->isValidUserToken($access_token[0])){
             return $response->withStatus(401);
           }
         }

     }
       $response = $next($request, $response);

       return $response;
    }
}
?>
