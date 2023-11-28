<?php
include 'db.php';

$sth = $dbconnection->prepare('
select studid, studfirstname, studlastname, studmidname, studprogid, studcollid, studyear,
collfullname, progfullname
from students 
inner join colleges on colleges.collid = students.studcollid
inner join programs on programs.progid = students.studprogid 
where students.studid=?');
$sth->bindParam(1, $_POST['id'], PDO::PARAM_INT);
$sth->execute();
$updateInfo = $sth->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Update</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="axios-student-update.js" defer></script>
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
                <?php
                echo "<option value='Select College'>----------- Select College -----------</option>";
                include 'colleges-list.php';
                ?>
            </select><br><br>

            <label for="program-select">Programs</label>
            <select name="program-select" id="program-select">
                <option>----------- Select Program -----------</option>
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
    //const urlParams = new URLSearchParams(window.location.search);
    //const id = urlParams.get('id');
    var post = <?php echo json_encode($_POST) ?>;
    var updateInfo = <?php echo json_encode($updateInfo) ?>;
    document.getElementById('reset-button').addEventListener("click", setDefaultInfo)
    
    console.log(updateInfo);
    document.getElementById('stud-id').value = post.id;
    document.getElementById('stud-first-name').value = updateInfo.studfirstname;
    document.getElementById('stud-middle-name').value = updateInfo.studmidname;
    document.getElementById('stud-last-name').value = updateInfo.studlastname;
    document.getElementById('college-select').value = updateInfo.studcollid;
    document.getElementById('program-select').value = updateInfo.studprogid;
    document.getElementById('stud-year').value = updateInfo.studyear;

    function setDefaultInfo() {
        document.getElementById('stud-id').value = post.id;
        document.getElementById('stud-first-name').value = updateInfo.studfirstname;
        document.getElementById('stud-middle-name').value = updateInfo.studmidname;
        document.getElementById('stud-last-name').value = updateInfo.studlastname;
        document.getElementById('college-select').value = updateInfo.studcollid;
        document.getElementById('program-select').value = updateInfo.studprogid;
        document.getElementById('stud-year').value = updateInfo.studyear;
    }
</script>