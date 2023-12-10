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
$collegeQuery = $dbconnection->prepare('SELECT collid, collfullname from colleges');
$collegeQuery->execute();
$colleges = $collegeQuery->fetchAll(PDO::FETCH_ASSOC);

$departmentQuery = $dbconnection->prepare('
select deptcollid, deptid, deptfullname from departments inner join colleges on departments.deptcollid = colleges.collid');
$departmentQuery->execute();
$departments = $departmentQuery->fetchALL(PDO::FETCH_ASSOC);

$sth = $dbconnection->prepare('select * from programs where progid = ?');
$sth->bindParam(1, $_POST['id'], PDO::PARAM_INT);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Update</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <form action="program-update-prep.php" method="post" id="program-update-form">
        <h3>Update Program Information<br><br>

            <label for="prog-id">Program ID</label>
            <input type="number" id="prog-id" name="prog-id" readonly><br><br>

            <label for="prog-full-name">Full Name</label>
            <input type="text" id="prog-full-name" name="prog-full-name"><br><br>

            <label for="prog-short-name">Short Name</label>
            <input type="text" id="prog-short-name" name="prog-short-name"><br><br>

            <label for="college-select">Colleges</label>
            <select name="college-select" id="college-select">
            </select><br><br>

            <label for="department-select">Departments</label>
            <select name="department-select" id="department-select">
            </select><br><br>

            <input type="submit" value="Save Updates">
            <button type="button" id="reset-button">Reset Entries</button>
        </h3>
    </form>

</body>

</html>

<script>
    const collegeSelect = document.getElementById('college-select');
    const departmentSelect = document.getElementById('department-select');
    const resetButton = document.getElementById('reset-button');

    var colleges = <?php echo json_encode($colleges) ?>;
    var departments = <?php echo json_encode($departments) ?>;
    var result = <?php echo json_encode($result) ?>;

    window.onload = function() {
        collegeOptions();
        setDefaultInfo();
        departmentOptions();
        setDefaultInfo();
    }

    function collegeOptions() {
        removeOptions(collegeSelect);
        var option = document.createElement("option");
        option.text = "----------- Select College -----------";
        option.value = "Select College";
        collegeSelect.add(option);

        colleges.forEach(element => {
            var option = document.createElement("option");
            option.text = element.collfullname;
            option.value = element.collid;
            collegeSelect.add(option);
        })
    }

    function departmentOptions() {
        removeOptions(departmentSelect);
        var option = document.createElement("option");
        option.text = "----------- Select Department -----------";
        option.value = "Select Department";
        departmentSelect.add(option);

        filteredDepartments = departments.filter(element => element.deptcollid == collegeSelect.value);

        filteredDepartments.forEach(element => {
            var option = document.createElement("option");
            option.text = element.deptfullname;
            option.value = element.deptid;
            departmentSelect.add(option);
        })
    }

    function removeOptions(selectElement) {
        var i, L = selectElement.options.length - 1;
        for (i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }

    function setDefaultInfo() {
        document.getElementById('prog-id').value = result.progid;
        document.getElementById('prog-full-name').value = result.progfullname;
        document.getElementById('prog-short-name').value = result.progshortname;
        document.getElementById('college-select').value = result.progcollid;
        document.getElementById('department-select').value = result.progcolldeptid;
    }

    collegeSelect.addEventListener('change', departmentOptions);
    resetButton.addEventListener('click', window.onload);
</script>