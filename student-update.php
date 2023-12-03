<?php
include 'db.php';
$collegeQuery = $dbconnection->prepare('SELECT * from colleges');
$collegeQuery->execute();
$colleges = $collegeQuery->fetchAll(PDO::FETCH_ASSOC);

$programQuery = $dbconnection->prepare('select colleges.collid, colleges.collfullname, programs.progid, programs.progfullname from colleges inner join programs on colleges.collid = programs.progcollid');
$programQuery->execute();
$programs = $programQuery->fetchALL(PDO::FETCH_ASSOC);

$student = $dbconnection->prepare('
select studid, studfirstname, studlastname, studmidname, studprogid, studcollid, studyear,
collfullname, progfullname
from students 
inner join colleges on colleges.collid = students.studcollid
inner join programs on programs.progid = students.studprogid 
where students.studid=?');
$student->bindParam(1, $_POST['id'], PDO::PARAM_INT);
$student->execute();
$updateInfo = $student->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Update</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <form action="student-update-prep.php" method="post" id="student-update-form">
        <h3>Update Student Information<br><br>

            <label for="stud-id">Student ID</label>
            <input type="number" id="stud-id" name="stud-id" readonly><br><br>

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

            <input type="submit" value="Save Updates">
            <button type="button" id="reset-button">Reset Entries</button>
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
    var post = <?php echo json_encode($_POST) ?>;
    var updateInfo = <?php echo json_encode($updateInfo) ?>;

    window.onload = function() {
        window.onload = collegeOptions();
        window.onload = setDefaultInfo();
        window.onload = programOptions();
        window.onload = setDefaultInfo();
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

    function setDefaultInfo() {
        document.getElementById('stud-id').value = post.id;
        document.getElementById('stud-first-name').value = updateInfo.studfirstname;
        document.getElementById('stud-middle-name').value = updateInfo.studmidname;
        document.getElementById('stud-last-name').value = updateInfo.studlastname;
        document.getElementById('college-select').value = updateInfo.studcollid;
        document.getElementById('program-select').value = updateInfo.studprogid;
        document.getElementById('stud-year').value = updateInfo.studyear;
    }

    collegeSelect.addEventListener('change', programOptions);
    resetButton.addEventListener('click', resetForm);
    document.getElementById('reset-button').addEventListener("click", setDefaultInfo)
</script>