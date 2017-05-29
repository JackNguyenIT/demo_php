<?php
require_once ("api/object/class.user.php");
header('Content-type: application/json');

    $user =  new User("10","acb","xyz");
    echo json_encode($user.get('fullname'));
?>