<?php  
SESSION_START();
include 'partials/dbconnect.php';

// Decode the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if room name is provided
if (!isset($data['roomName']) || empty($data['roomName'])) {
    echo json_encode(['success' => false, 'message' => 'Room name is required.']);
    exit;
}
$userId = $_SESSION['user_id'];
$createdBy = $_SESSION['uname'];
$roomName = mysqli_real_escape_string($conn, $data['roomName']); // Sanitize the room name

// Check if the room already exists
$checkSql = "SELECT * FROM `rooms` WHERE `room_id` = '$roomName'";
$result = mysqli_query($conn, $checkSql);

if ($result && mysqli_num_rows($result) > 0) {
    // Room already exists
    echo json_encode(['success' => true, 'message' => 'Room already exists.']);
} else {
    // Insert the new room
    $sql = "INSERT INTO `rooms` (`user_id`, `room_id`, `created_by`, `created_at`) VALUES ('$userId', '$roomName', '$createdBy', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Room created successfully!']);
    } else {
        echo json_encode(['success' => false, 'error' =>'room eror'. mysqli_error($conn)]);
    }
}
?>

