<?php
$host ="localhost";
$port="root";
$basename = "db_demo";
$pass="";


$conn = mysql_connect($host,$port,$pass,$basename);
if(!$conn){
	die("cannot connect database");
}else {
	mysql_select_db("db_demo");
}
?>