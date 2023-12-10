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
$prep= $dbconnection->prepare("SET FOREIGN_KEY_CHECKS=0");
$prep->execute();
$sth = $dbconnection->prepare("delete from programs where progid = ?");

$sth->bindParam(1, $_POST['id'], PDO::PARAM_INT);


if($sth->execute()){
    echo "Program ID#".$_POST['id']." deleted successfully.";
}else{
    echo "error";
}
?>
<form action="program-listing.php">
        <input type="submit" value="Program List" class="btn btn-primary"/>
</form>