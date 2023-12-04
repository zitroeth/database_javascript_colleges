<?php
session_start();
include 'db.php';
$collegeQuery = $dbconnection->prepare('SELECT * from colleges');
$collegeQuery->execute();
$colleges = $collegeQuery->fetchAll(PDO::FETCH_ASSOC);

$programQuery = $dbconnection->prepare('select colleges.collid, colleges.collfullname, programs.progid, programs.progfullname from colleges inner join programs on colleges.collid = programs.progcollid');
$programQuery->execute();
$programs = $programQuery->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Entry</title>
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
                <?php if(!isset($_SESSION["userid"])) 
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='user-registration.php'>User Registration</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='user-login.php'>User Login</a>
                        </li>";
                ?>
                <?php if(isset($_SESSION["userid"])) 
                    echo"<li class='nav-item'>
                    <a class='nav-link' href='student-listing.php'>Student Listing</a>
                    </li>";
                ?>
        </div>
    </nav>


    <form action="student-entry-prep.php" method="post" id="student-entry-form">
        <h3>Student Information Data Entry<br><br>

            <label for="stud-id">Student ID</label>
            <input type="number" id="stud-id" name="stud-id"><br><br>

            <label for="stud-first-name">First Name</label>
            <input type="text" id="stud-first-name" name="stud-first-name"><br><br>

            <label for="stud-middle-name">Middle Name</label>
            <input type="text" id="stud-middle-name" name="stud-middle-name"><br><br>

            <label for="stud-last-name">Last Name</label>
            <input type="text" id="stud-last-name" name="stud-last-name"><br><br>

            <label for="college-select">Colleges</label>
            <select name="college-select" id="college-select">
            </select><br><br>

            <label for="program-select">Programs</label>
            <select name="program-select" id="program-select">
            </select><br><br>

            <label for="stud-year">Year</label>
            <input type="number" id="stud-year" name="stud-year"><br><br>

            <input type="submit" value="Submit" class="btn btn-primary">
            <button type="button" id="reset-button" class="btn btn-danger">Clear Entries</button>
        </h3>
    </form>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    const collegeSelect = document.getElementById('college-select');
    const programSelect = document.getElementById('program-select');
    const resetButton = document.getElementById('reset-button');

    var colleges = <?php echo json_encode($colleges) ?>;
    var programs = <?php echo json_encode($programs) ?>;

    window.onload = collegeOptions();
    window.onload = programOptions();

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

    function programOptions() {
        removeOptions(programSelect);
        var option = document.createElement("option");
        option.text = "----------- Select Program -----------";
        option.value = "Select Program";
        programSelect.add(option);

        filteredPrograms = programs.filter(element => element.collid == collegeSelect.value);

        filteredPrograms.forEach(element => {
            var option = document.createElement("option");
            option.text = element.progfullname;
            option.value = element.progid;
            programSelect.add(option);
        })
    }

    function removeOptions(selectElement) {
        var i, L = selectElement.options.length - 1;
        for (i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }

    function resetForm() {
        document.getElementById("student-entry-form").reset();
        programOptions();
    }

    collegeSelect.addEventListener('change', programOptions);
    resetButton.addEventListener('click', resetForm);
</script>