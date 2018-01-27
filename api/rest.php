<?php
/**
 * Created by PhpStorm.
 * User: Mirko Eberlein
 * Date: 26.09.2017
 * Time: 20:03
 */
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');
ini_set('session.gc_maxlifetime',3600);
session_set_cookie_params(3600);
session_start();
switch($method){
    case "GET" : handleGet();
        break;
    case "POST" :handlePost();
        break;
}
function handleGet(){
    $content = "";
    $action = "";
    if(isset($_GET["content"])){
        $content =  $_GET["content"];
    }
    if(isset($_GET["action"])){
        $action =  $_GET["action"];
    }
    require_once("GETHandler.php");
    $handler = new GETHandler();
    echo $handler->start($content,$action);

}
function handlePost(){
    $data = json_decode(file_get_contents('php://input'), true);
    require_once("PostHandler.php");
    $handler = new POSTHandler();
    echo $handler->start($data);
}
