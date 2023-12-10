<?php
session_start();

if (!isset($_SESSION["userid"])) {
    echo "Log in first!"; ?>
    <form action="user-login.php">
        <input type="submit" value="User Login" class="btn btn-primary" />
    </form>
<?php exit;
}
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


    <form action="college-entry-prep.php" method="post" id="college-entry-form">
        <h3>College Entry<br><br>

            <label for="coll-id">College ID</label>
            <input type="number" id="coll-id" name="coll-id"><br><br>

            <label for="coll-full-name">Full Name</label>
            <input type="text" id="coll-full-name" name="coll-full-name"><br><br>

            <label for="coll-short-name">Short Name</label>
            <input type="text" id="coll-short-name" name="coll-short-name"><br><br>

            <input type="submit" value="Submit" class="btn btn-primary">
            <button type="button" id="reset-button" class="btn btn-danger">Clear Entries</button>
        </h3>
    </form>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    const resetButton = document.getElementById('reset-button');

    function resetForm() {
        document.getElementById("college-entry-form").reset();
        programOptions();
    }

    resetButton.addEventListener('click', resetForm);
</script>