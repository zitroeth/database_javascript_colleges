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
$sth = $dbconnection->prepare('
select progid, progfullname, progshortname, collfullname, deptfullname from programs 
inner join colleges on programs.progcollid = colleges.collid
inner join departments on programs.progcolldeptid = departments.deptid');
$sth->execute();
$result = $sth->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Listing</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark" style='position: -webkit-sticky; position: sticky; top: 0px; z-index: 1020;'> 
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/database_javascript_colleges">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student-listing.php">Student Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="college-listing.php">College Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="program-listing.php">Program Listing</a>
                </li>
        </div>
    </nav>

    <nav class="navbar bg-body-tertiary" style='position: -webkit-sticky; position: sticky; top: 56px; z-index: 1019;'>
        <div class="container-fluid">
            <div>
                <form action="program-entry.php">
                    <input type="submit" value="Add New Program" class="btn btn-primary" />
                </form>
            </div>
            <div>
                <h2>Program Listing</h2>
            </div>

            <div style='display: flex; flex-direction: row;'> 
                <label for='logout-button'>
                    You are logged in as: <?php echo (intval($_SESSION['usertype']) == 2) ? "<b>admin</b> " : "<b>student</b> " ?>
                </label>
                <form action="user-login.php">
                    <input type="submit" value="Logout" class="btn btn-success" id='logout-button'/>
                </form>
            </div>
        </div>
    </nav>

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
                    <form action="program-delete.php" method="post" id='submittingForm'>
                        <button class="btn btn-danger" name="id" data-bs-dismiss="modal" id='delete-button'>Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <table id="student-table">
        <tr style='position: -webkit-sticky; position: sticky; top: 118px; z-index: 1018;'>
            <th>ID</th>
            <th>Full Name</th>
            <th>Short Name</th>
            <th>College</th>
            <th>Department</th>
            <th width='1'>Update</th>
            <th width='1'>Delete</th>
        </tr>

        <?php

        foreach ($result as $value) {
            $id = intval($value['progid']);
            echo "<tr><td>" . $value['progid'] . "</td><td>" . $value['progfullname'] . "</td><td>" . $value['progshortname'] . "</td><td>" . $value['collfullname'] . "</td><td>" . $value['deptfullname'] . "</td>";
            if ($_SESSION['usertype'] == 2) echo "
                <form action='program-update.php' method='post' id='submittingForm'>

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
                <form action='program-update.php' method='post' id='submittingForm'>

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
        modalBody.textContent = `Are you sure you want to delete Program ID#${userid}?`
    })
</script>