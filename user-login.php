<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="card text-bg-dark mb-3 mx-auto">
        <div class="card-header">
            <h2>User Login</h2>
        </div>
        <div class="card-body">
            <form action="user-login-prep.php" method="post" id='login-form'>
                <label for="username">Username</label>
                <input type="text" id="username" name="username"><br><br>

                <label for="password">Password</label>
                <input type="text" id="password" name="password"><br><br>

                <button type="button" class="btn btn-outline-primary">Login</button>
                <button type="button" class="btn btn-outline-danger" id='clear-button'>Clear</button>
            </form>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    document.getElementById('clear-button').addEventListener("click", reset);

    function reset(){
       document.getElementById('login-form').reset();
    }

</script>