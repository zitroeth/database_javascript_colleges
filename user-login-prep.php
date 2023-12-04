<?php
session_start();
session_unset();
include 'db.php';

$sth = $dbconnection->prepare("select * from users where username= ?");
$sth->bindParam(1, $_POST['floating-username'], PDO::PARAM_STR);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);

if(password_verify($_POST['floating-password'], $result['userpass'])){
    echo "login success";
    $_SESSION['userid']=$result['userid'];
    $_SESSION['usertype']=$result['usertype'];
}else{
    echo "login failed";
}


?>
<form action="student-listing.php">
        <input type="submit" value="Student Listing" class="btn btn-primary"/>
</form>