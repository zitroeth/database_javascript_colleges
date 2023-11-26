<?php
include 'db.php';
$sth = $dbconnection->prepare('SELECT * from colleges');
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $value){
    echo "<option  value='".$value['collid']."'>".$value['collfullname']."</option>";
}
?>