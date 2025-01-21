<?php  
session_start();
include('partials/dbconnect.php');
// echo $_GET['roomName'];
// exit;

// Check if the room name is provided in the URL
if (!isset($_GET['roomName'])) {
    echo json_encode(['error' => 'Room name is not set.']);
    exit; // Exit if room name is not provided
}

$roomName = mysqli_real_escape_string($conn, $_GET['roomName']); // Sanitize the room name

// Fetch chat messages for the specific room
$sql = "SELECT * FROM `roommessage` WHERE `room_name` = '$roomName' ORDER BY time "; // Use the correct column name

$result = mysqli_query($conn, $sql);
$messages = [];

// Check if there are messages in the result
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = [
            'sender' => $row['user_name'], // You might want to fetch the username if needed
            'message' => $row['message'],
            'time' => $row['time'] // You can include the time if you want
        ];
    }
}

// Return messages as JSON
echo json_encode($messages);
?>
