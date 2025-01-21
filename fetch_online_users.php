<?php
session_start();
include('partials/dbconnect.php');

// Fetching online users except the current user
$current_user_id = $_SESSION['user_id'];
$sql = "SELECT `id`, `uname`, `is_online` FROM users WHERE `id` != '$current_user_id' ORDER BY `is_online` DESC";
$result = mysqli_query($conn, $sql);

$on = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $on[] = $row; // Add each online user to the array
    }
}

echo json_encode($on); // Return the online users as JSON
?>


