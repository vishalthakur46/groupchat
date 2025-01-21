<?php
session_start();
include('partials/dbconnect.php'); // Your database connection file
// Decode the POST data
$data = json_decode(file_get_contents('php://input'), true);
$sender_id = $_SESSION['user_id']; // Get the sender's user ID from the session
$receiver_id = $data['receiverId']; // Receiver ID from the form
$message = mysqli_real_escape_string($conn, $data['message']); // Escape the message
// Insert message directly into the database
$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
//echo $receiver_id;
?>
