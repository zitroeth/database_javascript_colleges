<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="card text-bg-dark mb-3 mx-auto" style="width:30%; margin-top: 10%;">
        <div class="card-header">
            <h2>User Registration</h2>
        </div>
        <div class="card-body">
            <form action="user-registration-prep.php" method="post" id='registration-form'>

                <div class="form-floating">
                    <input type="number" class="form-control" id="floating-userid" name="floating-userid">
                    <label for="floating-userid">User ID</label>
                </div><br>

                <div class="form-floating">
                    <input type="text" class="form-control" id="floating-username" name="floating-username">
                    <label for="floating-username">Username</label>
                </div><br>

                <div class="form-floating">
                    <input type="text" class="form-control" id="floating-password" name="floating-password">
                    <label for="floating-password">Password</label>
                </div><br>

                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" name="floatingSelect" aria-label="Floating label select example">
                        <option value="1">User</option>
                        <option value="2">Admin</option>
                    </select>
                    <label for="floatingSelect">User Type</label>
                </div><br>

                <button type="submit" class="btn btn-outline-primary">Register</button>
                <button type="button" class="btn btn-outline-danger" id='clear-button'>Clear</button>
            </form>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    document.getElementById('clear-button').addEventListener("click", reset);

    function reset() {
        document.getElementById('registration-form').reset();
    }
</script>