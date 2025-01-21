<?php  
$servername = "localhost";
$username = "root";
$password = "";
$database ="user_table";

$conn =mysqli_connect($servername, $username, $password, $database);
if($conn)
{
  //echo "connected";
}
else
{
    die("failed ".mysqli_connect_error());
}
?>

