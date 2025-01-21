<?php
session_start();
include 'partials/dbconnect.php'; 

$user_name = $_SESSION['uname']; 

$query = "SELECT `room_id` FROM `group_members` WHERE `user_name` = '$user_name'";
$result = $conn->query($query);

$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
        
    }
}
echo json_encode($rooms);




?>
