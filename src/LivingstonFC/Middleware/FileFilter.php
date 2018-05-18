<?php

namespace LivingstonFC\Middleware;

class FileFilter
{

    protected $allowedFiles = ['image/jpeg', 'image/png'];
    public function __invoke($request, $response, $next)
    {
      $files = $request->getUploadedFiles();
      $new_file = $files['image'];
      $new_file_type = $new_file->getClientMediaType();

      if (!in_array($new_file_type, $this->allowedFiles)){
        return $response->withStatus(415);
      }

       $response = $next($request, $response);

       return $response;
    }
}
?>
