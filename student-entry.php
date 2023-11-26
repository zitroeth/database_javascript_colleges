<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Entry</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="axios-student-entry.js" defer></script>
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
            <select name="college-select" id="college-select" >
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

            <input type="submit" value="Submit">
            <button type="button" id="reset-button">Clear Entries</button>
        </h3>
    </form>
    </table>

</body>

</html>