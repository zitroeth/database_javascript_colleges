<?php
include 'db.php';
$sth = $dbconnection->prepare('
select students.studid, students.studfirstname, students.studlastname, students.studmidname, students.studprogid, students.studcollid, students.studyear,
colleges.collfullname, programs.progfullname
from students 
inner join colleges on colleges.collid = students.studcollid
inner join programs on programs.progid = students.studprogid');
$sth->execute();
$result = $sth->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Listing</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <table id="customers">
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Initial</th>
            <th>College</th>
            <th>Program Enrolled</th>
            <th>Year</th>
            <th></th>
        </tr>

        <?php
            foreach($result as $value){
                echo "<tr><td>".$value['studid']."</td><td>".$value['studlastname']."</td><td>".$value['studfirstname']."</td><td>"
                .$value['studmidname']."</td><td>".$value['collfullname']."</td><td>".$value['progfullname']."</td><td>".$value['studyear']."</td><td>
                <i class='bi bi-pencil-square' style='font-size:2rem; color: #0e3d21;'></i>
                <i class='bi bi-trash3-fill' style='font-size:2rem; color: #b31717;'></i>
                </td>
                </tr>";
            }
        ?>
    </table>
</body>

</html>