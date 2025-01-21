<?php
include "partials/dbconnect.php";
$fname = $lname = $uname= $email = $pass = $cpass= "";
$fnameerr = $lnameerr = $unameerr = $emailerr = $passerr= $cpasserr= "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
 
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];

   $valid = true;

   if (empty($_POST["fname"])) {
       $fnameerr = "First name is required";
       $valid = false;
   } else {
       $fname = htmlspecialchars(trim($_POST["fname"]));
   }

   
   if (empty($_POST["lname"])) {
       $lnameerr = "Last name is required";
       $valid = false;
   } else {
       $lname = htmlspecialchars(trim($_POST["lname"]));
   }

   if (empty($_POST["uname"])) {
       $unameerr = "Username is required";
       $valid = false;
   } else {
       $uname = htmlspecialchars(trim($_POST["uname"]));
   }

   if (empty($_POST["email"])) {
       $emailerr = "Email is required";
       $valid = false;
   } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
       $emailerr = "Invalid email format";
       $valid = false;
   } else {
       $email = htmlspecialchars(trim($_POST["email"]));
   }
   if (empty($_POST["pass"])) {
      $passerr = "Password is required";
      $valid = false;
       } else {
      $pass = $_POST["pass"];
      
      if (strlen($pass) < 8) {
          $passerr = "Password must be at least 8 characters long";
          $valid = false;
      }
     
      if (!preg_match('/[A-Z]/', $pass)) {
          $passerr = "Password must include at least one uppercase letter";
          $valid = false;
      }
      if (!preg_match('/[a-z]/', $pass)) {
          $passerr = "Password must include at least one lowercase letter";
          $valid = false;
      }
      if (!preg_match('/[0-9]/', $pass)) {
          $passerr = "Password must include at least one number";
          $valid = false;
      }
      if (!preg_match('/[\W_]/', $pass)) {
          $passerr = "Password must include at least one special character";
          $valid = false;
      }
  }

  if (empty($_POST["cpass"])) {
      $cpasserr = "Please confirm your password";
  } else {
      $cpass = $_POST["cpass"];
      if ($cpass !== $pass) {
          $cpasserr = "Passwords do not match";
          $valid = false;
      }
  }

   if ($valid) {
      $sql = "SELECT * FROM users WHERE uname = '$uname' OR email = '$email'";
      $result1 = mysqli_query($conn, $sql);
      $check = mysqli_num_rows($result1);
   
      if ($check > 0) {
         echo "User exists";
      } else {
   
         if ($valid) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
   
            $sql2 = "INSERT INTO `users`(`fname`, `lname`,`uname`,`email`, `password`,`time`) VALUES ('$fname', '$lname','$uname','$email', '$hash', current_timestamp())";
            //echo $sql2; die;
            $result = mysqli_query($conn, $sql2);
   
            if ($result) {
               header('location: loginpage.php');
               exit;
            } else {
               echo "Error: " . mysqli_error($conn);
            }
         } else {
          //  echo "Passwords do not match";
         }
      }
      
   }
}

?>
