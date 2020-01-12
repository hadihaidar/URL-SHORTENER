<?php
include "connection.php";
//delete from link tABLE AND the ip address table
$url = $db->quote($_POST['url']);
$query = $db->exec("DELETE FROM link WHERE (new=$url)");
$query = $db->exec("DELETE FROM ipaddress WHERE (short=$url)");
//DELETE FROM MyGuests WHERE id=3

?>