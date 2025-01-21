<?php

include 'partials/dbconnect.php';  
require 'loginlogic.php';


?>
<?php  
SESSION_START();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']= true)
{
   header('location: welcome.php'); 
}
?>
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
                                    <h4>Username/Email</h4>
                                </label>
                                <input type="text" class="form-control" id="uname" name="uname" value="<?php echo $uname; ?>">
                                <div class="error"><?php echo $unameerr; ?></div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="email">
                                    <h4>Email Address:</h4>
                                </label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                <div class="error"><?php echo $emailerr; ?></div>
                            </div> -->
                            <div class="form-group">
                                <label for="pass">
                                    <h4>Password:</h4>
                                </label>
                                <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $pass; ?>" >
                                <div class="error"><?php echo $passerr; ?></div>
                            </div>
                
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="LOG-IN" name="submit"><strong> OR 

</strong> <a class="btn btn-primary " href="index.php" role="button">SIGN-UP</a>
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