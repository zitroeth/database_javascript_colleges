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

$sth = $dbconnection->prepare("update programs
set progfullname = ?, progshortname = ?, progcollid = ?, progcolldeptid = ?
where progid = ?");

$sth->bindParam(1, $_POST['prog-full-name'], PDO::PARAM_STR);
$sth->bindParam(2, $_POST['prog-short-name'], PDO::PARAM_STR);
$sth->bindParam(3, $_POST['college-select'], PDO::PARAM_INT);
$sth->bindParam(4, $_POST['department-select'], PDO::PARAM_INT);
$sth->bindParam(5, $_POST['prog-id'], PDO::PARAM_INT);

if (
    intval($_POST['prog-id']) != 0 && !empty(trim($_POST['prog-full-name'])) &&
    !empty(trim($_POST['prog-short-name'])) && intval($_POST['college-select']) != 0 &&
    intval($_POST['department-select']) != 0
) {
    $sth->execute();
} else {
    echo "error";
}
?>
<form action="program-listing.php">
        <input type="submit" value="Program List" class="btn btn-primary"/>
</form>