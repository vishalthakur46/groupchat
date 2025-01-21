<?php
include 'partials/dbconnect.php';
$uname = $email = $pass = $showerr= "";
$unameerr = $emailerr = $passerr = "";
$login = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    
   // $email = $_POST['email'];
    $valid = true;
    if (empty($_POST["uname"])) {
        $unameerr = "Username is required";
        $valid = false;
    }
    // if (empty($_POST["email"])) {
    //     $emailerr = "Email is required";
    //     $valid = false;
    // } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    //     $emailerr = "Invalid email format";
    //     $valid = false;
  //  }
    if (empty($_POST["pass"])) {
        $passerr = "Password is required";
        $valid = false;
    } else {
        $pass = $_POST["pass"];
    }

    $sql = "SELECT * FROM users WHERE `uname` = '$uname' OR `email` = '$uname'";
    $result = mysqli_query($conn, $sql);
    $Num_Rows = mysqli_num_rows($result);
     if ($Num_Rows == 1) {
      $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['password'])){
            SESSION_START();
            $login = true;
            $user_id = $row['id'];
            $username = $row['uname'];
            $_SESSION['loggedin'] = true;
            $_SESSION['uname'] = $username;
            $_SESSION['user_id']=$user_id;
            $sql1 = "UPDATE `users` set `is_online` = true WHERE `id` = '$user_id' ";
            $result1 = mysqli_query($conn, $sql1);
            header('location: welcome.php');
        } else {
            $passerr = "Invalid Password";
        }
    } else {
        $passerr = "Username or email does not exist";
    }
}
    ?>


