<?php
session_start(); 

if (!isset($_SESSION["userid"])) {
    echo "Log in first!"; ?>
    <form action="user-login.php">
        <input type="submit" value="User Login" class="btn btn-primary"/>
    </form>
<?php exit;
}

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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="student-update-delete.php" method="post" id='submittingForm'>
                        <button class="btn btn-danger" name="id" data-bs-dismiss="modal" id='delete-button'>Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <form action="student-entry.php">
        <input type="submit" value="Add New Student" class="btn btn-primary" />
    </form>

    <label style="position:absolute; top:0; right:0; width: 15% !important;">
    You are logged in as: <?php echo (intval($_SESSION['usertype'])==2) ? "<b>admin</b> ": "<b>student</b> " ?>
    </label>
    <form action="user-login.php">
        <input type="submit" value="Logout" class="btn btn-success" id='logout-button' style="position:absolute; top:0; right:0;" />
    </form>

    <table id="student-table">
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Initial</th>
            <th>College</th>
            <th>Program Enrolled</th>
            <th>Year</th>
            <th></th>
            <th></th>
        </tr>

        <?php

        foreach ($result as $value) {
            $id = intval($value['studid']);
            echo "<tr><td>" . $value['studid'] . "</td><td>" . $value['studlastname'] . "</td><td>" . $value['studfirstname'] . "</td><td>"
                . $value['studmidname'][0] . "." . "</td><td>" . $value['collfullname'] . "</td><td>" . $value['progfullname'] . "</td><td>" . $value['studyear'] . "</td>
                ";
            if ( $_SESSION['usertype']==2 || $_SESSION['userid'] == $id) echo "
                <form action='student-update.php' method='post' id='submittingForm'>

                <td>
                <button name='id' value='$id' class='invis' style='margin: 0; padding: 0;'>
                    <i class='bi bi-pencil-square' style='font-size:2rem; color: #0e3d21;'></i>
                </button>
                </td>
                </form>

                <td>
                <button name='id' value='$id' class='invis' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-whatever='$id' style='margin: 0; padding: 0;'>
                <i class='bi bi-trash3-fill' style='font-size:2rem; color: #b31717;' id='$id'></i>
                </button>
                </td>
                ";
            else echo "
                <form action='student-update.php' method='post' id='submittingForm'>

                <td>
                <button name='id' value='$id' class='invis' disabled style='margin: 0; padding: 0;'>
                    <i class='bi bi-pencil-square' style='font-size:2rem; color: rgba(14, 63, 34, 0.473);'></i>
                </button>
                </td>
                </form>

                <td>
                <button name='id' value='$id' class='invis' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-whatever='$id' disabled style='margin: 0; padding: 0;'>
                <i class='bi bi-trash3-fill' style='font-size:2rem; color: #b317177a;' id='$id'></i>
                </button>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>


</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    const exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const userid = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.

        const modalBody = exampleModal.querySelector('.modal-body')
        const deleteButton = document.getElementById('delete-button')
        deleteButton.value = userid
        modalBody.textContent = `Are you sure you want to delete User ID#${userid}?`
    })
</script>