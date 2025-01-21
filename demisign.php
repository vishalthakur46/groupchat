<?php
// Initialize variables
$firstName = $lastName = $username = $email = "";
$firstNameErr = $lastNameErr = $usernameErr = $emailErr = "";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    // Validate first name
    if (empty($_POST["first_name"])) {
        $firstNameErr = "First name is required";
        $valid = false;
    } else {
        $firstName = htmlspecialchars(trim($_POST["first_name"]));
    }

    // Validate last name
    if (empty($_POST["last_name"])) {
        $lastNameErr = "Last name is required";
        $valid = false;
    } else {
        $lastName = htmlspecialchars(trim($_POST["last_name"]));
    }

    // Validate username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $valid = false;
    } else {
        $username = htmlspecialchars(trim($_POST["username"]));
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }
    if ($valid) {
        echo '<div class="alert alert-success">Form submitted successfully!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>User Registration Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $firstName; ?>">
                <div class="error"><?php echo $firstNameErr; ?></div>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $lastName; ?>">
                <div class="error"><?php echo $lastNameErr; ?></div>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>">
                <div class="error"><?php echo $usernameErr; ?></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <div class="error"><?php echo $emailErr; ?></div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>













<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP-LOGIN</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1><b>Login To Continue</b></h1>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                           
                         <div class="form-group">
                                <label for="uname">
                                    <h4>Username:</h4>
                                </label>
                                <input type="text" class="form-control" id="uname" name="uname" value="<?php echo $uname; ?>">
                                <div class="error"><?php echo $unameerr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    <h4>Email Address:</h4>
                                </label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                <div class="error"><?php echo $emailerr; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="pass">
                                    <h4>Password:</h4>
                                </label>
                                <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $pass; ?>" >
                                <div class="error"><?php echo $passerr; ?></div>
                            </div>
                
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Sign-UP" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (Optional, but needed for things like modals or dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>