<?php
session_start();
include('partials/dbconnect.php'); // Your database connection file

// Check if roomName is provided in the GET request
if (isset($_GET['roomName'])) {
    $roomName = mysqli_real_escape_string($conn, $_GET['roomName']);
} else {
    echo json_encode(['success' => false, 'error' => 'Room name is required.']);
    exit;
}

// Decode the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Ensure the POST data is valid
if (!isset($data['message'])) {
    echo json_encode(['success' => false, 'error' => 'Message is required.']);
    exit;
}

// Get the sender's user ID from the session
$sender_id = $_SESSION['user_id'];  // userid sending message into group
$user_name = $_SESSION['uname'];  // username sending message into the group 


// Escape the message to prevent SQL injection
$message = mysqli_real_escape_string($conn, $data['message']);

// Prepare the SQL statement to prevent SQL injection
$sql = "INSERT INTO roommessage (sender_id,user_name, message, time, room_name) VALUES ('$sender_id', '$user_name', '$message', current_timestamp(), '$roomName')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>
