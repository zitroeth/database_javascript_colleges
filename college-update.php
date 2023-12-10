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
$sth = $dbconnection->prepare('select * from colleges where collid = ?');
$sth->bindParam(1, $_POST['id'], PDO::PARAM_INT);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Update</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <form action="college-update-prep.php" method="post" id="college-update-form">
        <h3>Update College Information<br><br>

            <label for="coll-id">College ID</label>
            <input type="number" id="coll-id" name="coll-id" readonly><br><br>

            <label for="coll-full-name">College Full Name</label>
            <input type="text" id="coll-full-name" name="coll-full-name"><br><br>

            <label for="coll-short-name">College Short Name</label>
            <input type="text" id="coll-short-name" name="coll-short-name"><br><br>

            <input type="submit" value="Save Updates">
            <button type="button" id="reset-button">Reset Entries</button>
        </h3>
    </form>

</body>

</html>

<script>
    const resetButton = document.getElementById('reset-button');
    var result = <?php echo json_encode($result) ?>;

    window.onload = function() {
        window.onload = setDefaultInfo();
    }

    function setDefaultInfo() {
        document.getElementById('coll-id').value = result.collid;
        document.getElementById('coll-full-name').value = result['collfullname'];
        document.getElementById('coll-short-name').value = result['collshortname'];
    }

    resetButton.addEventListener('click', setDefaultInfo);
</script>