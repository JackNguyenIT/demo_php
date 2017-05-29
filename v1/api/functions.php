<?php 
include 'dbconfig.php';
require_once ("object/class.user.php");
require_once ("object/class.result.php");

function loginAccount($username,$password){
	$sql = "select * from tb_account where username='$username' and password='$password'";
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result)) {
			return $row;
		}
	}
	return null;
}

function checkAccount($username,$email){
	$sql = "select * from tb_account where username='$username' or email='$email'";
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result)) {
			return true;
		}
	}
	return false;
}

function getAccountById($userId){
	$sql = "select * from tb_account where id='$userId'";
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result)) {
			return parseDatabaseToUser($row);
		}
	}
	return null;
}

function parseDatabaseToUser($data){
	$user = new User();
	$user->id = $data['id'];
	$user->fullname = $data['fullname'];
	$user->email = $data['email'];
	$user->avatar = $data['image'];
	$user->role = $data['role'];
	$user->created_datetime =$data['created_datetime'];
	$user->updated_datetime = $data['updated_datetime'];
	return $user;
}

function insertUser($user,$password){
	$datetime = date("Y-m-d H:i:s");
	$sql = "INSERT INTO `tb_account` (`id`, `username`, `password`, `email`, `image`, `fullname`, `role`, `created_datetime`, `updated_datetime`) 
	VALUES (NULL, '$user->username', '$password', '$user->email', '', '$user->fullname', '$user->role', '$datetime', '$datetime')";
	return  mysql_query($sql);
}

function getResultWithError($message){
	$result = new Result();
	$result->message= $message;
	return $result;
}

function getListUser(){
	$sql = "select * from tb_account";
	$result = mysql_query($sql);
	$array  = array();
	if($result){
		while ($row = mysql_fetch_array($result)) {
			$array[] = parseDatabaseToUser($row);
		}
	}
	return $array;
}
?>