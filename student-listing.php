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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

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

        foreach ($result as $value) {
            $id = intval($value['studid']);
            echo "<tr><td>" . $value['studid'] . "</td><td>" . $value['studlastname'] . "</td><td>" . $value['studfirstname'] . "</td><td>"
                . $value['studmidname'] . "</td><td>" . $value['collfullname'] . "</td><td>" . $value['progfullname'] . "</td><td>" . $value['studyear'] . "</td><td>

                <form target='_blank' action='student-update.php' method='post' id='submittingForm'>
                <button name='id' value='$id'>
                <svg xmlns='http://www.w3.org/2000/svg' width='34' height='34' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                <rect class='btn' width='34' height='34' >
                </svg>
                </button>

                <i class='bi bi-trash3-fill' style='font-size:2rem; color: #b31717;' data-bs-toggle='modal' data-bs-target='#exampleModal'
                    id='bi bi-trash3-fill<?php echo $id; ?>'></i>
                </td>
                </tr>
                </form>";
        }
        ?>
    </table>


</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>

</script>