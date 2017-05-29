<?php 
include 'functions.php';
require_once ("object/class.user.php");
require_once ("object/class.result.php");

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

function responseOther(){
	$method =  $_SERVER['REQUEST_METHOD'];
	$result = new Result();
	$result->message="Method [$method] not support this api.";
	echo json_encode($result);
}

function responsePostData(){
	if(validate()){
		register();
	}
}

function validate(){
	if(!isset($_POST["username"])){
		echo json_encode(getResultWithError("Missing [username]"));
		return false;
	}
	if(!isset($_POST['password'])){
		echo json_encode(getResultWithError("Missing [password]"));
		return false;
	}
	if(!isset($_POST['fullname'])){
		echo json_encode(getResultWithError("Missing [fullname]"));
		return false;
	}
	if(!isset($_POST['email'])){
		echo (getResultWithError("Missing [email]"));
		return false;
	}
	if(!isset($_POST['avatar'])){
		echo (getResultWithError("Missing [avatar]"));
		return false;
	}
	return true;
}

function register(){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$avatar = $_POST['avatar'];

	if(checkAccount($username,$email)){
			echo json_encode(getResultWithError("[username] or [email] Already exists."));
	}else{
		$user = new User();
		$user->username = $username;
		$user->fullname = $fullname;
		$user->email = $email;
		$result= null;
		if(insertUser($user,$password)){
			$result = getResultWithError("Register is success.");
			$result->status =1;

		}else{
            $result = getResultWithError("Register is false.");
		}
		echo json_encode($result);
	}
}