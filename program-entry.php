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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Entry</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/database_javascript_colleges">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student-entry.php">Student Entry</a>
                </li>
                <?php if (!isset($_SESSION["userid"]))
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='user-registration.php'>User Registration</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='user-login.php'>User Login</a>
                        </li>";
                ?>
                <?php if (isset($_SESSION["userid"]))
                    echo "<li class='nav-item'>
                    <a class='nav-link' href='student-listing.php'>Student Listing</a>
                    </li>";
                ?>
        </div>
    </nav>


    <form action="program-entry-prep.php" method="post" id="program-entry-form">
        <h3>Program Entry<br><br>

            <label for="prog-id">Program ID</label>
            <input type="number" id="prog-id" name="prog-id"><br><br>

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

            <input type="submit" value="Submit" class="btn btn-primary">
            <button type="button" id="reset-button" class="btn btn-danger">Clear Entries</button>
        </h3>
    </form>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    const collegeSelect = document.getElementById('college-select');
    const departmentSelect = document.getElementById('department-select');
    const resetButton = document.getElementById('reset-button');

    var colleges = <?php echo json_encode($colleges) ?>;
    var departments = <?php echo json_encode($departments) ?>;

    window.onload = collegeOptions();
    window.onload = departmentOptions();

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

    function resetForm() {
        document.getElementById("program-entry-form").reset();
    }

    collegeSelect.addEventListener('change', departmentOptions);
    resetButton.addEventListener('click', resetForm);
</script>