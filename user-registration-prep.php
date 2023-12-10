<?php
session_start();

if (!isset($_SESSION["userid"])) {
    echo "Log in first!"; ?>
    <form action="user-login.php">
        <input type="submit" value="User Login" class="btn btn-primary" />
    </form>
<?php exit;
}
include 'db.php';

$password= password_hash($_POST['floating-password'], PASSWORD_BCRYPT);

$sth = $dbconnection->prepare("INSERT INTO `usjr`.`users` VALUES(?,?,?,?)");
$sth->bindParam(1, $_POST['floating-userid'], PDO::PARAM_INT);
$sth->bindParam(2, $_POST['floating-username'], PDO::PARAM_STR);
$sth->bindParam(3, $password, PDO::PARAM_STR);
$sth->bindParam(4, $_POST['floatingSelect'], PDO::PARAM_INT);


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