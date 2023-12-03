<?php
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

</head>

<body>

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

            <input type="submit" value="Submit">
            <button type="button" id="reset-button">Clear Entries</button>
        </h3>
    </form>
</body>

</html>
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