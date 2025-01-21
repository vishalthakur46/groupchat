<?php
include 'partials/dbconnect.php';
SESSION_START();
$user_id = $_SESSION['user_id'];
$sql = "UPDATE `users` SET `is_online` = false WHERE `id` = '$user_id'";
$result = mysqli_query($conn, $sql);
SESSION_UNSET();
SESSION_DESTROY();
header('location: loginpage.php');
exit;
