<?php
session_start();
include('partials/dbconnect.php');
$roomName = $_GET['roomName']; 

// Fetching online users except the current user
$current_user_id = $_SESSION['uname'];
$sql = "SELECT `room_id`, `user_name`, `is_online` FROM group_members WHERE 
`user_name` != '$current_user_id' AND  `room_id` = '$roomName' ORDER BY `is_online` DESC";
$result = mysqli_query($conn, $sql);

$sql2 = "UPDATE `group_members` set `is_online` = true WHERE `user_name` = '$current_user_id' ";
$result2 = mysqli_query($conn, $sql2);


$row = mysqli_num_rows($result);
// var_dump($row);
// exit;
$on = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $on[] = $row; // Add each online user to the array
    }
}

echo json_encode($on); // Return the online users as JSON
?>
