<?php
include "connection.php";
$sql = $db->exec("DROP TABLE IF EXISTS link ");
$sql = $db->exec("DROP TABLE IF EXISTS users ");
$link = "CREATE TABLE `link` (
        `original` varchar(1000) NOT NULL,
        `new` varchar(1000) NOT NULL,
        `email` varchar(500) NOT NULL,
        `apikey` varchar(32) NOT NULL
      ) ";

$users = "CREATE TABLE `users` (
    `first` varchar(100) NOT NULL,
    `last` varchar(100) NOT NULL,
    `Email` varchar(500) NOT NULL,
    `password` varchar(1000) NOT NULL,
    `apikey` varchar(32) NOT NULL
  ) ";
$link = $db->exec($link);
$users = $db->exec($users);
$primary = $db->exec("
    ALTER TABLE `link`
    ADD PRIMARY KEY (`new`,`email`);"
);
$primary = $db->exec("
    ALTER TABLE `users`
    ADD PRIMARY KEY (`Email`),
    ADD UNIQUE KEY `apikey` (`apikey`);
    COMMIT;"
);
