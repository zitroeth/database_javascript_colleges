<?php
include 'db.php';

$sth = $dbconnection->prepare("delete from students where studid = ?");

$sth->bindParam(1, $_POST['id'], PDO::PARAM_INT);


if($sth->execute()){
    echo "User ID#".$_POST['id']." deleted successfully.";
}else{
    echo "error";
}
?>
<form action="student-listing.php">
        <input type="submit" value="Student List" class="btn btn-primary"/>
</form>