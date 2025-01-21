<?php
session_start();
include('partials/dbconnect.php');

//fetching online users except the current user

$current_user_id = $_SESSION['user_id'];
$sql = "SELECT `id`, `uname` FROM users WHERE `is_online` = TRUE AND `id` != '$current_user_id'";
$result = mysqli_query($conn, $sql);

$users = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
//fetch every user except online users
$sql1 = "SELECT `id`, `uname` FROM users WHERE `id` != '$current_user_id'";
$result1 = mysqli_query($conn, $sql);

$usersfound = [];
if (mysqli_num_rows($result) > 0) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $usersfound[] = $row1;
    }
}
echo json_encode($usersfound);
echo json_encode($users);
?>



//fetching online users except the current user
$current_user_id = $_SESSION['user_id'];
$sql = "SELECT `id`, `uname`, `is_online` FROM users WHERE `is_online` = TRUE AND `id` != '$current_user_id'";
$result = mysqli_query($conn, $sql);

$users = [];
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
$users[] = $row;
}
}

// Include all users
$sql1 = "SELECT `id`, `uname`, `is_online` FROM users WHERE `id` != '$current_user_id'";
$result1 = mysqli_query($conn, $sql1); // Fixing this to use $sql1 instead of $sql

$usersfound = [];
if (mysqli_num_rows($result1) > 0) {
while ($row1 = mysqli_fetch_assoc($result1)) {
$usersfound[] = $row1;
}
}
echo json_encode(['online' => $users, 'all' => $usersfound]); // Sending both online and all users










<<!-- Buttons for Room Actions -->
    <button class="btn btn-primary" id="show-create-room">Create Room</button>
    <button class="btn btn-secondary" id="show-join-room">Join Room</button>

    <!-- Room Creation Section (Initially Hidden) -->
    <div class="mb-3 hidden" id="create-room-section">
        <label for="room-name" class="form-label">Create a Room</label>
        <input type="text" class="form-control" id="room-name" placeholder="Enter room name" required>
        <button class="btn btn-primary mt-2" id="create-room-btn">Create Room</button>
    </div>

    <!-- Join Room Section (Initially Hidden) -->
    <div class="mb-3 hidden" id="join-room-section">
        <label for="room-id" class="form-label">Join a Room</label>
        <input type="text" class="form-control" id="room-id" placeholder="Enter room ID" required>
        <button class="btn btn-secondary mt-2" id="join-room-btn">Join Room</button>
    </div>


    // Show Create Room Section
    $('#show-create-room').click(function() {
    $('#create-room-section').toggleClass('hidden'); // Toggle visibility
    $('#join-room-section').addClass('hidden'); // Hide Join Room section if visible
    });

    // Show Join Room Section
    $('#show-join-room').click(function() {
    $('#join-room-section').toggleClass('hidden'); // Toggle visibility
    $('#create-room-section').addClass('hidden'); // Hide Create Room section if visible
    });





    $.ajax({
    url: 'create_room.php',
    type: 'POST',
    data: JSON.stringify({
    room_name: room_name,
    room_message: room_message
    }),
    contentType: 'application/json',
    dataType: 'json',
    success: function(data) {
    if (data.success) {
    $('room-name').val('') //clear the field
    loadroomMessages(room_name); //reload the chat room

    }
    },
    error: function(xhr, status, error) {
    console.log('Error sending message:', error);
    }
    });
    }
    });

    });


    function refreshMessages() {
    if (currentReceiverId) { // Only refresh if a receiver is selected
    loadMessages(currentReceiverId);
    }












    <?php
    SESSION_START();
    include 'partials/dbconnect.php';
    //Decode the Post data


    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['roomName'])) {
        exit;
    }
    echo json_encode(['success' => false, 'message' => 'Room name is required.']);

    $userId = $_SESSION['user_id'];
    $createdBy = $_SESSION['uname'];
    $roomName = $data['roomName'];
    // echo "$userId";
    //$room_message = mysqli_real_escape_string($conn, $data['room_message']);

    $sql = "INSERT INTO `rooms` (`user_id`, `room_id`, `created_by`, `created_at`) VALUES ('$userId', '$roomName', '$createdBy', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Room created successfully!']);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }

    ?>



    $.ajax({
    url:'group_chat.php', // second target file
    type:'POST',
    data:JSON.stringify({
    roomName: roomName
    }),
    success: function(response){
    console.log('response from the group_chat.php', response);
    //
    }
    }) ;


send group message


    <?php
    session_start();
    include('partials/dbconnect.php'); // Your database connection file
    // echo $_GET['roomName'];
    // Decode the POST data
    $data = json_decode(file_get_contents('php://input'), true);
    $sender_id = $_SESSION['user_id']; // Get the sender's user ID from the session
    // echo $roomName;
    // exit;
    //$receiver_id = $data['receiverId']; // Receiver ID from the form
    $message = mysqli_real_escape_string($conn, $data['message']); // Escape the message
    // Insert message directly into the database
    $roomName = $_GET['roomName'];
    // echo "Room Name: " . htmlspecialchars($roomName);
    // exit; 
    // For debugging purposes
    // echo "Room Name: " . htmlspecialchars($roomName);
    $sql = "INSERT INTO roommessage (sender_id, message , time ,room_name ) VALUES ('$sender_id', '$message',current_timestamp(), '$roomName' )";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
    //echo $receiver_id;
    ?>






fetch_room_messages

<?php  
session_start();
include('partials/dbconnect.php');

// if (isset($_GET['roomName'])) {
//     $roomName = $_GET['roomName'];
//     echo "Room Name: " . htmlspecialchars($roomName); // Print the room name
// } else {
//     echo "Room name is not set.";
// }

// Decode the POST data
$data = json_decode(file_get_contents('php://input'), true);
//print_r($_POST); die;
// Check if receiver_id is provided
$roomName = $_GET['roomName'];
if (isset($_POST['receiever_id'])) {
   
    $sender_id  = $_SESSION['user_id']; // current logged-in user
 // receiver ID from POST request

    // Fetch chat messages between the logged-in user and the selected receiver
    $sql = "SELECT * FROM `roommessages` WHERE `room_id` = '$roomName'";

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



test classs


/* General Body Styles */
body {
    background: linear-gradient(to right, #007bff, #6c757d); /* Blue to gray gradient */
    min-height: 100vh; /* Ensure it covers the full screen */
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Arial', sans-serif; /* Use a modern sans-serif font */
}
.hidden {
    display: none;
    /* Use a class to hide elements */
}

/* Card Styles */
.container {
    background: #fff; /* White background for card */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 5px 22px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

/* Title Styles */
h1 {
    color: #156ac6; /* Blue color for headings */
}

h3 {
    color: #333; /* Dark color for subheadings */
}

/* Online Users List Styles */
#online-users {
    max-height: 300px; /* Max height for user list */
    overflow-y: auto; /* Scrollable when content overflows */
    border-radius: 5px; /* Rounded corners */
    background: #f8f9fa; /* Light background for contrast */
    padding: 15px; /* Padding for spacing */
    margin-bottom: 15px; /* Spacing from chat box */
}

/* List Item Styles */

  
.dec-card {
    border: 1px solid #183b5e; /* Border around chat box */
    border-radius: 5px; /* Rounded corners */
    background: #f8f9fa; /* Light background for chat box */
    padding: 15px;
     /* Padding for chat box */
    height: 600px; /* Fixed height for chat box */
    overflow-y: fixed; /* Scrollable when content overflows */
    margin-bottom: 5px;
    margin-top:1px; /* Spacing from form */
    border:none;

}
.list-group-item {
    display: flex; /* Flexbox for alignment */
    justify-content: space-between; /* Space between elements */
    align-items: center; /* Center items vertically */
    padding: 10px 15px; /* Padding for list items */
    border: none; /* Remove border */
    transition: background-color 0.3s; /* Smooth background transition */
}

.list-group-item:hover {
    background-color: #e2e6ea; /* Light gray on hover */
}

.active {
    background-color: #007bff; /* Active item background */
    color: white; /* Active item text color */
}

/* Online Status Dot */
.online-status {
    height: 10px;
    width: 10px;
    border-radius: 50%; /* Circle shape */
    display: inline-block;
    margin-right: 8px; /* Space between dot and text */
}

/* Chat Box Styles */
#chat-box {
    border: 1px solid #dee2e6; /* Border around chat box */
    border-radius: 5px; /* Rounded corners */
    background: #f8f9fa; /* Light background for chat box */
    padding: 15px; /* Padding for chat box */
    height: 300px; /* Fixed height for chat box */
    overflow-y: auto; /* Scrollable when content overflows */
    margin-bottom: 15px; /* Spacing from form */
}

/* Chat Form Styles */
#chat-form {
    display: flex; /* Flexbox for form layout */
}
/* Custom CSS to remove borders */
.no-border {
    border: none !important; /* Remove any border */
}

#chat-message {
    border-radius: 10px 0 0 5px; /* Rounded corners */
    border: 1px solid #ced4da; /* Border color */
}

#chat-form button {
    border-radius: 0 5px 5px 0; /* Rounded corners */
}

/* Room Creation Section Styles */
#room-section {
    margin-top: 15px;
    margin-bottom:10px; /* Spacing from other elements */
}

/* Responsive Styles */
@media (max-width: 768px) {
    .container {
        width: 90%; /* Full width on small screens */
    }

    #online-users {
        max-height: 200px; /* Reduce height on small screens */
    }

    #chat-box {
        height: 200px; /* Reduce height on small screens */
    }
}







css changes 10:28

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat - <?php echo htmlspecialchars($roomName); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      
        .lists-container {
            display: flex;
            justify-content: space-between;
        }

    
        .d-flex {
            display: flex;
            justify-content: space-between;
            /* Align items to the edges */
            align-items: center;
            /* Center items vertically */
        }

        #online-users
     {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .list-group-item,
        #chat-box div {
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5 bg-white rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-left">Room ID: <?php echo htmlspecialchars($roomName); ?></h2>
            <h2 id="username-heading" class="text-right">UserID:<?php echo htmlspecialchars($user_name); ?></h2>

        </div>
        <hr class="my-4">
        <div class="lists-container  align-items-center mb-3">
            <div id="group-users" class="border p-3">
                <h3>Users in Room:</h3>
                <ul id="group-user-list" class="list-group">
                    <!-- Users will be loaded here -->
                </ul>
            </div>


        </div>
        <div id="group-chat-box" class="border p-3 mb-3" style="height: 300px; overflow-y: scroll;">
            <!-- Group chat messages will appear here -->
        </div>


        <form id="group-chat-form">
            <div class="input-group">
                <input type="hidden" id="room-name" value="<?php echo htmlspecialchars($roomName); ?>">
                <input type="text" id="group-chat-message" class="form-control form-control-lg" placeholder="Type a message" required>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>









    set user offline



    function setUserOffline() {
        $.ajax({
            url: 'set_roomuser_offline.php', // Call the PHP script to set user offline
            type: 'POST',
            data: {
                user_name: userName // Send the username
            },
            success: function() {
                console.log('User set offline successfully.');
            },
            error: function(xhr, status, error) {
                console.error("Error setting user offline: ", status, error);
            }
        });
    }

    // Use visibilitychange event to detect when the user leaves the page
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'hidden') {
            setUserOffline();
        }
    });
