<?php
include 'db.php';

$sth = $dbconnection->prepare("INSERT INTO `usjr`.`users` VALUES(?,?,?,?)");
$sth->bindParam(1, $_POST['floating-userid'], PDO::PARAM_INT);
$sth->bindParam(2, $_POST['floating-username'], PDO::PARAM_STR);
$sth->bindParam(3, $_POST['floating-password'], PDO::PARAM_STR);
$sth->bindParam(4, $_POST['floatingSelect'], PDO::PARAM_INT);

var_dump($_POST);

if (
    intval($_POST['floating-userid']) != 0 && !empty(trim($_POST['floating-username'])) &&
    !empty(trim($_POST['floating-password'])) && intval($_POST['floatingSelect']) != 0
) {
    $sth->execute();
} else {
    echo "error";
}
?>
<form action="user-login.php">
        <input type="submit" value="User Login" class="btn btn-primary"/>
</form>