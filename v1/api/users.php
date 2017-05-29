<?php 
include 'functions.php';
include 'token.php';
require_once ("object/class.user.php");
require_once ("object/class.result.php");

header('Content-type: application/json');

$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
	case 'GET':
	responseGetData();
	break;
	case 'POST':
	responsePostData();
	break;
	default:
	responseOther();
	break;
}

function responseGetData(){
	$headers = getallheaders();
	if(checkAccessToken($headers)){
		if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
			$userId = $_GET['user_id'];
			getUserbyId($userId);
		}else{
			responseListUser();
		}
	}
}

function responsePostData(){
	echo json_encode("waiting");
}

function responseOther(){
	echo json_encode("waiting");
}

function responseListUser(){
	$result = new Result();
	$result->status =1;
	$result->data = getListUser();
	$result->message ="Get list user success";
	echo json_encode($result);
}

function getUserbyId($userId){
	$user = getAccountById($userId);
	$result = new Result();
	if($user==null){
		$result->status =0;
		$result->message ="Get user false";
	}else{
		$result->status =1;
		$result->data = getAccountById($userId);
		$result->message ="Get user success";
	}
	echo json_encode($result);
}