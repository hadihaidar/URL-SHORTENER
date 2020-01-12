<?php
include "connection.php";
$user_ip = $db->quote($_POST['ip']);
$y = $db->quote($_POST['url']);
$browser = $db->quote($_POST['browser']);
$query = $db->exec("INSERT INTO ipaddress VALUES (NULL,$user_ip ,$y,$browser);");

?>