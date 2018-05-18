<?php

namespace LivingstonFC\Middleware;

class ImageRemoveExif
{
    public function __invoke($request, $response, $next)
    {
      $files = $request->getUploadedFiles();

      $new_file = $files['image'];
      $new_file_type = $new_file->getClientMediaType();

      $uploadFileName = $new_file->getClientFilename();

      $path = $request->getUri()->getPath();
      $pngfile = "assets/images/". $path . '/' . substr($uploadFileName, 0, -4) . ".png";
      $new_file->moveTo($pngfile);

      if ("image/jpeg" == $new_file_type){
          $_img = imagecreatefromjpeg("assets/images/" . $path . '/' . $uploadFileName);
          imagepng($_img, $pngfile);
      }

      $request = $request->withAttribute('png_filename', $pngfile);

       $response = $next($request, $response);

       return $response;
    }
}
?>
