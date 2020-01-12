<?php
include "connection.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}
//regex that checks if the url is valid
$original = $db->quote($_POST["url"]);

function generateID() {

	global $db;
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	$ID=  substr(str_shuffle($permitted_chars), 0, 5);
	$query = $db->query("SELECT * FROM link");
	foreach ($query as $row) {
			if ($ID==$row['new']) {
				return generateID();
			}
	}
	return $ID;
}
$valid = preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu',
		$_POST['url']);
if(!$valid){
die("invalid url");
}
$generate = generateID();
$new =  $db->quote($generate);
$email = $db->quote($_SESSION["user"]);
$key = $db->quote($_SESSION["key"]);
$query = $db->exec("INSERT INTO link VALUES ($original, $new,$email,$key,0);");
if ($query) {
    echo ($urlink.$generate);
}

?>
