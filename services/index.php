<?php
//namespace gpstakipsistemi;
/*
 *@Package GPSTAKİPSİSTEMİ
 *@Author Ahmet ÇAKIRCI <ahmetcakirci@gmail.com>
 *@Version 1.0
 *@Description
 *@Copyright
 *@Date October 2015
 */

set_time_limit(86400);
ini_set('display_errors',"0");
header ('Content-type: application/json; charset=utf-8');

include_once $_SERVER['DOCUMENT_ROOT'].'lib'.DIRECTORY_SEPARATOR.'autoloader.php';


require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => false));

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "path"=>["/type","/Type","/TYPE"],
    "realm" => "Protected",
    "environment" => "HTTP_AUTHORIZATION",
    "users" => [
        "root" => "admin",
        "user" => "admin"
    ]
]));

$app->error(function ( \ErrorException $e ) use ($app) {
	$app->response()->header("Content-Type", "application/json");

});

$app->error(function ( \Exception $e ) use ($app) {
	$app->response()->header("Content-Type", "application/json");

});
	
$app->get('/type/:typeName', function ($typeName) use($app)  {
    $app->response()->header("Content-Type", "application/json");
    $Bridge=new Bridge();
    $result=$Bridge->Type($typeName);
    echo json_encode(array($result));
});

$app->get('/TYPE/:typeName', function ($typeName) use($app)  {
    $app->response()->header("Content-Type", "application/json");
	$Bridge=new Bridge();
	$result=$Bridge->Type($typeName);
	echo json_encode(array($result));
});

$app->get('/Type/:typeName', function ($typeName) use($app)  {
    $app->response()->header("Content-Type", "application/json");
	$Bridge=new Bridge();
	$result=$Bridge->Type($typeName);
	echo json_encode(array($result));
});	
// run the Slim app
$app->run();