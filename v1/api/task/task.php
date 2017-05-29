<?php 
include '../token.php';
require_once ("../object/class.result.php");
header('Content-type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'GET':
		responseGetData();
		break;
	default:
		responseOther();
		break;
}

function responseGetData(){
$userId = $_GET['user_id'];
$taskId = $_GET['task_id'];
	$headers = getallheaders();
if(checkAccessToken($headers)){
	echo json_encode("$userId + $taskId");
}
}

function responseOther(){
	$method =  $_SERVER['REQUEST_METHOD'];
	$result = new Result();
	$result->message="Method [$method] not support this api.";
	echo json_encode($result);
}

?>