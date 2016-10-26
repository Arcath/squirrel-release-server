<?php
require('vendor/autoload.php');

$configFile = file_get_contents('config.json');
$config = json_decode($configFile);

$app = new Slim\App();

$app->get('/{platform}/RELEASES', function($request, $response, $args){
  global $config;

  $platform = $request->getAttribute('platform');

  $data = "";
  $pkgs = scandir(dirname(__FILE__) . '/releases/' . $platform);

  foreach ($pkgs as $pkg) {
    if($pkg[0] != '.'){
      $re = '/-(.*?)-/';
      preg_match($re, $pkg, $matches);

      $version = Naneau\SemVer\Parser::parse($matches[1]);

      $hash = sha1_file(dirname(__FILE__) . '/releases/' . $platform . '/' .$pkg);
      $filesize = filesize(dirname(__FILE__) . '/releases/' . $platform . '/' .$pkg);

      /*
      $data .= $hash;
      $data .= ' ';
      $data .= '/releases/' . $platform . '/' . $pkg;
      $data .= ' ';
      $data .= $filesize;
      $data .= "\r\n";
      */

      $response->getBody()->write($hash . ' ' . $config->baseurl . '/releases/' . $platform . '/' . $pkg . ' ' . $filesize . "\r\n");
    }

  }

  return $response;
});

$app->run();
?>
