<?php
require('vendor/autoload.php');

$configFile = file_get_contents('config.json');
$config = json_decode($configFile);

$app = new Slim\App();

$app->get('/{platform}/RELEASES', function($request, $response, $args){
  global $config;

  $platform = $request->getAttribute('platform');

  $pkgs = scandir(dirname(__FILE__) . '/releases/' . $platform);

  if(isset($_GET['localVersion'])){
    $localVersion = Naneau\SemVer\Parser::parse($_GET['localVersion']);
  }else{
    $localVersion = Naneau\SemVer\Parser::parse('0.0.0');
  }

  foreach ($pkgs as $pkg) {
    if($pkg[0] != '.'){
      $re = '/-(.*?)-/';
      preg_match($re, $pkg, $matches);

      $version = Naneau\SemVer\Parser::parse($matches[1]);

      if(Naneau\SemVer\Compare::greaterThan($version, $localVersion) || Naneau\SemVer\Compare::equals($version, $localVersion)){
        $hash = sha1_file(dirname(__FILE__) . '/releases/' . $platform . '/' .$pkg);
        $filesize = filesize(dirname(__FILE__) . '/releases/' . $platform . '/' .$pkg);

        $response->getBody()->write($hash . ' ' . $config->baseurl . '/releases/' . $platform . '/' . $pkg . ' ' . $filesize . "\r\n");
      }
    }
  }

  return $response;
});

$app->get('/{platform}/notes/{version}', function($request, $response, $args){
  $response->getBody()->write('Release ' . $request->getAttribute('version'));

  return $response;
});

$app->run();
?>
