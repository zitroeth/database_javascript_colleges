<?php
session_start();
session_unset();
include 'db.php';

$sth = $dbconnection->prepare("select * from users where username= ?");
$sth->bindParam(1, $_POST['floating-username'], PDO::PARAM_STR);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);

if($result!=null && password_verify($_POST['floating-password'], $result['userpass'])){
    $_SESSION['userid']=$result['userid'];
    $_SESSION['usertype']=$result['usertype'];
    ?><meta http-equiv="refresh" content="0; URL='student-listing.php'"/><?php
}else{
    echo "login failed";
    ?><meta http-equiv="refresh" content="3; URL='user-login.php'"/> <?php
}