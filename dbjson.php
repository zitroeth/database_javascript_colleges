<?php
include 'db.php';
$sth = $dbconnection->prepare('select colleges.collid, colleges.collfullname, programs.progid, programs.progfullname from colleges inner join programs on colleges.collid = programs.progcollid');
$sth->execute();
$result = $sth->fetchALL(PDO::FETCH_ASSOC);
$json= json_encode($result);
echo $json;
?>