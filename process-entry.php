<?php
include 'db.php';
$username=$_POST['username'];
$password=password_hash($_POST['password'], PASSWORD_BCRYPT);
$sth = $dbconnection->prepare('INSERT into users(id, username, password) VALUES (NULL, ?, ?)');
$sth->bindParam(1, $username, PDO::PARAM_STR);
$sth->bindParam(2, $password, PDO::PARAM_STR);
$sth->execute();
?>