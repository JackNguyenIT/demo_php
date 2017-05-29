<?php 
include 'dbconfig.php';
require_once ("object/class.user.php");
require_once ("object/class.result.php");
require_once ("object/class.auth.php");

function checkAccessToken($headers){
	if(isset($headers['access_token'])){
	 	$access_token =  $headers['access_token'];
	 	if(checkAccessTokenDatabase($access_token)){
	 		return true;
	 	}else{
	 		echo json_encode(resultWithError("Header [access_token] invalid"));
	 		return false;
	 	}
	}else{
		echo json_encode(resultWithError("Header Missing [access_token]"));
		return false;
	}
}

function getAccessTokenFromDatabase($access_token){
	$sql = "select * from tb_access_token where access_token='$access_token'";
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result)) {
			return $row;
		}
	}
	return null;
}

function getAccessTokenById($token_id){
$sql = "select * from tb_access_token where id='$token_id'";
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result)) {
			return $row;
		}
	}
	return null;
}
function getAccessTokenByUserId($user_id){
	$sql = "select * from tb_access_token where user_id='$user_id'";
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result)) {
			return $row;
		}
	}
	return null;
}

function deleteAccessTokenById($token_id){
		$sql = "DELETE FROM `tb_access_token` WHERE `tb_access_token`.`id` = '$token_id'";
		return  mysql_query($sql);
}


function checkAccessTokenDatabase($access_token){
	$access = getAccessTokenFromDatabase($access_token);
	return $access !=null;
}

function createAccessTokenByUser($user_id){
	$datetime = date("Y-m-d H:i:s");
	$access_token =  md5(uniqid($user_id, true));
	$sql ="INSERT INTO `tb_access_token` (`id`, `user_id`, `access_token`, `created_datetime`, `updated_datetime`) VALUES (NULL, '$user_id', '$access_token', '$datetime', '$datetime')";
	return  mysql_query($sql);
}

function createAccessTokenLogin($user){
	$rowDelete = getAccessTokenByUserId($user->id);
	if($rowDelete!=null){
		deleteAccessTokenById($rowDelete['id']);
	}
	$result =createAccessTokenByUser($user->id);
	 if($result){
	 	$row = getAccessTokenByUserId($user->id);
	 	if ($row!=null) {
	 	     $auth =new Auth();
			 $auth->id = $row['id'];
			 $auth->user = $user;
			 $auth->access_token = $row['access_token'];

			return $auth ;		
	 	}
	 }
	 return null;
}

function resultWithError($message){
	$result = new Result();
	$result->message= $message;
	return $result;
}

?>
