<?php
session_start();
include 'db.php';

$sth = $dbconnection->prepare("INSERT INTO `usjr`.`students` VALUES(?,?,?,?,?,?,?)");
$sth->bindParam(1, $_POST['stud-id'], PDO::PARAM_INT);
$sth->bindParam(2, $_POST['stud-first-name'], PDO::PARAM_STR);
$sth->bindParam(3, $_POST['stud-last-name'], PDO::PARAM_STR);
$sth->bindParam(4, $_POST['stud-middle-name'], PDO::PARAM_STR);
$sth->bindParam(5, $_POST['program-select'], PDO::PARAM_INT);
$sth->bindParam(6, $_POST['college-select'], PDO::PARAM_INT);
$sth->bindParam(7, $_POST['stud-year'], PDO::PARAM_INT);



if (
    intval($_POST['stud-id']) != 0 && !empty(trim($_POST['stud-first-name'])) &&
    !empty(trim($_POST['stud-last-name'])) && !empty(trim($_POST['stud-middle-name'])) &&
    intval($_POST['program-select']) != 0 && intval($_POST['college-select']) != 0 && intval($_POST['stud-year']) != 0
) {
    $sth->execute();
} else {
    echo "eror";
}

if (!isset($_SESSION["userid"])) { ?>
    <form action="user-login.php">
        <input type="submit" value="User Login" class="btn btn-primary" />
    </form>
<?php exit;
} else { ?>
    <form action="student-listing.php">
        <input type="submit" value="Student List" class="btn btn-primary" />
    </form>
<?
} ?>