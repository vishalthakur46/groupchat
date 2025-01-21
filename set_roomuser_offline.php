<?php
session_start();
include 'partials/dbconnect.php';
//$room_id = $_GET['roomName'];
// Check if the user is logged in
$room_id = $_GET['roomName'];
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user_name = $_SESSION['uname'];
    
    // Update the user's online status
    $sql = "UPDATE `group_members` SET `is_online` = false WHERE `user_name` = '$user_name' AND `room_id` = '$room_id' ";
   $result= mysqli_query($conn, $sql);
if($result){
    echo json_encode(['success' => true, 'user_name' => $user_name, 'user_id' => $room_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
}
}
?>
