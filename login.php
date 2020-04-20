<?php
include "connection.php";
session_start();
if (isset($_POST['login'])) {
    $query = $db->query("SELECT * FROM users");
    $COUNT = 0;


    foreach ($query as $row) {
        if ($row['Email'] == $_POST['email']) {
            $COUNT = 1;

            if ($row['password'] ==($_POST["password"])) {
                $_SESSION['user'] = $_POST['email'];
                $_SESSION['name'] = $row['first'];
                $_SESSION['last'] = $row['last'];
				$_SESSION['key']= $row['apikey'];
                header("location:press.php");
            } else {
                header("location:index.php?empty=Incorrect Password");
            }
        }
    }
    if ($COUNT == 0) {
        header("location:index.php?empty=Email doesn't exist");
    }
}
elseif (isset($_POST['logout'])) {
    session_destroy();
    header("location:index.php");
}
else{
    header("location:index.php");
}
