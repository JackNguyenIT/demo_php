<?php
include 'functions.php';
include 'token.php';
require_once ("object/class.user.php");
require_once ("object/class.result.php");
require_once ("object/class.auth.php");

header('Content-type: application/json');

$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
	case 'POST':
	responsePostData();
	break;
	default:
	responseOther();
	break;
}


function responsePostData(){
	if(isset($_POST["username"]) && isset($_POST["password"])){
		login();
	}else{
		$result = new Result();
		$result->message="Missing [username] or [password]";
		echo json_encode($result);
	}
	
}

function responseOther(){
	$method =  $_SERVER['REQUEST_METHOD'];
	$result = new Result();
	$result->message="Method [$method] not support this api.";
	echo json_encode($result);
}

function login(){
	$result = new Result();
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	
	$dataUser = loginAccount($username,$password);
	if($dataUser!=null){
		$user = parseDatabaseToUser($dataUser);
		$auth= createAccessTokenLogin($user);
		if($auth!=null){
			$result->message ="Login is success";

			$result->data =$auth;
			$result->status = 1;
		}else{
			$result->message ="Login is false";
		}
		
	}else{
		$result->message ="Username or Password Invalid.";
	}

	echo json_encode($result);
}