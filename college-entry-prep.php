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

$sth = $dbconnection->prepare("INSERT INTO `usjr`.`colleges` VALUES(?,?,?)");
$sth->bindParam(1, $_POST['coll-id'], PDO::PARAM_INT);
$sth->bindParam(2, $_POST['coll-full-name'], PDO::PARAM_STR);
$sth->bindParam(3, $_POST['coll-short-name'], PDO::PARAM_STR);


if (
    intval($_POST['coll-id']) != 0 && !empty(trim($_POST['coll-full-name'])) &&
    !empty(trim($_POST['coll-short-name']))
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
    <form action="college-listing.php">
        <input type="submit" value="College List" class="btn btn-primary" />
    </form>
<?php
} ?>