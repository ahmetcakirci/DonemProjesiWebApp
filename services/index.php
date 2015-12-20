<?php
namespace gpstakipsistemi;
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
use gpstakipsistemi\lib\type\method;
include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'services'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'autoloader.php';

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => false));

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "path"=>["/login","/location","/locations"],
    "realm" => "Protected",
    "environment" => "HTTP_AUTHORIZATION",
    "users" => [
        "root" => "admin",
        "user" => "admin"
    ],
    //"environment" => "REDIRECT_HTTP_AUTHORIZATION",
    "error" => function ($request, $response, $arguments) use ($app) {
            $data = [];
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response->write(json_encode($response, JSON_UNESCAPED_SLASHES));
            echo json_encode($data);
        }
]));

$app->error(function ( \ErrorException $e ) use ($app) {
	$app->response()->header("Content-Type", "application/json");

});

$app->error(function ( \Exception $e ) use ($app) {
	$app->response()->header("Content-Type", "application/json");

});

$app->get('/login/:email/:password/:imei', function ($email,$password,$imei) use($app)  {
    $app->response()->header("Content-Type", "application/json");
    $Method=new method();
    $result=$Method->login($email,$password,$imei);
    echo json_encode($result);
});

$app->get('/location/:idusers/:latitude/:longitude', function ($idusers,$latitude,$longitude) use($app)  {
    $app->response()->header("Content-Type", "application/json");
    $Method=new method();
    $result=$Method->location_now($idusers,$latitude,$longitude);
    echo json_encode($result);
});

$app->get('/locations/:idusers', function ($idusers) use($app)  {
    $app->response()->header("Content-Type", "application/json");
    $Method=new method();
    $result=$Method->locations($idusers);
    echo json_encode($result);
});
// run the Slim app
$app->run();
