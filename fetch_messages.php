<?php  
session_start();
include('partials/dbconnect.php');

// Decode the POST data
$data = json_decode(file_get_contents('php://input'), true);
//print_r($_POST); die;
// Check if receiver_id is provided
if (isset($_POST['receiever_id'])) {
   
    $sender_id  = $_SESSION['user_id']; // current logged-in user
    $receiver_id = $_POST['receiever_id']; // receiver ID from POST request

    // Fetch chat messages between the logged-in user and the selected receiver
    $sql = "SELECT * FROM `messages` WHERE (`sender_id` = '$sender_id'  AND `receiver_id` ='$receiver_id') 
            OR (`sender_id` = '$receiver_id' AND `receiver_id` = '$sender_id')";

    $result = mysqli_query($conn, $sql);
    $messages = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages []= [
                'sender' => ($row['sender_id'] == $sender_id) ? 'you' : 'other', 
                'message' => $row['message']
            ];
        }
    }

    // Return messages as JSON
    echo json_encode($messages);
} else {
    echo json_encode(['error' => 'Receiver ID is not provided']);
}
?>
