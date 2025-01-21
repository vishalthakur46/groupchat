<?php
SESSION_START();
include 'partials/dbconnect.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: loginpage.php');
    exit;
}

$roomName = $_GET['roomName'];
//$userId = $_SESSION['user_id'];
$user_name = $_SESSION['uname'];
$sql = "SELECT * FROM  `group_members`  where `room_id`= '$roomName' AND `user_name` = '$user_name'";
$result = mysqli_query($conn, $sql);
$userexist = mysqli_num_rows($result);

//evar_dump($userexist);xit;
if ($userexist == 0 && !empty($roomName)) {

    $sql1 = "INSERT INTO `group_members` (`room_id`, `user_name`, `joined_at`) VALUES ('$roomName', '$user_name',current_timestamp())";
    $result1 = mysqli_query($conn, $sql1);
    if (!$result1) {
        // echo "member  added";
    }
}
// $sql2 = "UPDATE `group_members` set `is_online` = true WHERE `user_name` = '$user_name' ";

// $result2 = mysqli_query($conn, $sql2);





// $data = json_decode(file_get_contents('php://input'), true);

// // Check if room name is provided
// if (!isset($data['roomName']) || empty($data['roomName'])) {
//     echo json_encode(['success' => false, 'message' => 'Room name is required.']);
//     exit;
// }

// $userId = $_SESSION['user_id'];
// $createdBy = $_SESSION['uname'];
// $roomName = mysqli_real_escape_string($conn, $data['roomName']); // Sanitize the room name

//     if ($data['roomName']) {
//         echo json_encode(['success' => true, 'message' => 'Room joined successfully!']);
//     } else {
//         echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
//     }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat - <?php echo htmlspecialchars($roomName); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #ccd1d1, #f8f9f9);
            min-height: 100vh;
            /* Ensure it covers the full screen */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            /* Use a modern sans-serif font */
        }

        .container {
            background: linear-gradient(to right, #ccd1d1, #f8f9f9);
        }

        /* Layout for the main container */
        .chat-container {
            background: linear-gradient(to right, #ccd1d1, #f8f9f9);
            display: flex;
            justify-content: space-between;
            height: 65vh;
            /* Adjust height to fit your window */
        }

        /* Style for the user list section */
        #group-users {
            width: 20%;
            /* Reduced width */
            background-color: #fff;
            border-radius: 8px;
            /* Slightly smaller radius */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Reduced shadow size */
            padding: 10px;
            /* Reduced padding */
            margin-right: 8px;
            /* Reduced margin between user list and chat box */
            overflow-y: auto;
            font-size: 0.9rem;
            /* Reduced font size */
        }

        /* Style for the chat box */
        #group-chat-box {
            width: 78%;
            /* Reduced width */
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 10px;
            /* Reduced padding */
            overflow-y: scroll;
            height: 65vh;
            /* Reduced height to match the container */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
            /* Reduced font size for chat messages */
        }

        /* Style for individual messages and users */
        .list-group-item,
        #group-chat-box div {
            padding: 8px 10px;
            /* Reduced padding */
            border-bottom: 1px solid #dee2e6;
            font-size: 0.9rem;
            /* Slightly smaller font size */
        }

        /* For the chat form */
        /* Add space below the input group */
        #group-chat-form {
            margin-top: 8px;
            margin-bottom: 5px;
            /* 5px space below the form */
        }

        .input-group {
            display: flex;
        }

        /* Adjustments to input and button */
        .input-group input {
            flex: 1;
            font-size: 0.9rem;
            /* Smaller input font size */
            padding: 8px;
            margin-bottom: 3px;
            /* Smaller padding */
        }

        .input-group button {
            margin-left: 5px;
            /* Reduced margin */
            font-size: 0.9rem;
            /* Reduced button font size */
            padding: 8px 12px;
            /* Smaller padding for the button */
        }


        /* Simple responsive adjustment for smaller screens */
        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
            }

            #group-users,
            #group-chat-box {
                width: 100%;
            }

            #group-users {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5 bg-white rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-left">Room ID: <?php echo htmlspecialchars($roomName); ?></h2>
            <h2 id="username-heading" class="text-right">UserID: <?php echo htmlspecialchars($user_name); ?></h2>
        </div>
        <hr class="my-4">

        <div class="chat-container">
            <!-- User list on the left -->
            <div id="group-users" class="border p-3">
                <h3>Users in Room:</h3>
                <ul id="group-user-list" class="list-group">
                    <!-- Users will be loaded here -->
                </ul>
            </div>

            <!-- Group chat on the right -->
            <div id="group-chat-box" class="border p-3 mb-3">
                <!-- Group chat messages will appear here -->
            </div>
        </div>

        <form id="group-chat-form">
            <div class="input-group">
                <input type="hidden" id="room-name" value="<?php echo htmlspecialchars($roomName); ?>">
                <input type="text" id="group-chat-message" class="form-control form-control-lg" placeholder="Type a message" required>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>

    <script>
        //           // Function to set user offline
        //           $(window).on('beforeunload', function() {

        //     alert('Beforeunload event triggered.'); 
        //     console.log('Beforeunload event triggered.');// Log to the console

        //    // Send an AJAX request to set the user offline
        //     $.ajax({
        //         url: 'set_roomuser_offline.php', // Call the PHP script to set user offline
        //         type: 'POST',
        //         async: false, // Ensure the request completes before leaving the page
        //         data: {
        //             user_name: "<?php echo htmlspecialchars($user_name); ?>" // Send the username
        //         }
        //     });

        //     return 'You are leaving the room.'; // This message may or may not be displayed
        // });

        $(document).ready(function() {
            const roomName = $('#room-name').val();

            // Function to load users in the room
            function loadRoomUsers() {

                $.ajax({
                    url: 'fetch_room_users.php', // Endpoint to get users in the room
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        roomName: roomName
                    },
                    success: function(data) {
                        console.log(data);
                        const userList = $('#group-user-list');
                        userList.empty(); // Clear the list
                        data.forEach(function(user) {
                            const li = $('<li></li>')
                                .addClass('list-group-item')
                                .text(user.user_name);
                            // const statusDot = $('<span></span>').css({
                            //     'height': '10px',
                            //     'width': '10px',
                            //     'border-radius': '50%',
                            //     'display': 'inline-block',
                            //     'margin-left': '10px',
                            //     'background-color': user.is_online == 1 ? 'green' : 'red' // Green for online, Red for offline
                            // });

                            // li.append(statusDot);
                            userList.append(li);
                        });
                    }
                });
            }

            // Function to load messages in the room
            function loadRoomMessages() {

                $.ajax({
                    url: 'fetch_room_messages.php', // Endpoint to get messages in the room
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        roomName: roomName
                    },
                    success: function(data) {
                        console.log(data);
                        const chatBox = $('#group-chat-box');
                        chatBox.empty(); // Clear previous messages
                        data.forEach(function(message) {
                            const senderName = (message.sender === "<?php echo htmlspecialchars($user_name) ?>") ? "you " : message.sender;
                            // Create a Date object from the message time (assuming message.time is in a standard format)
                            const messageTime = new Date(message.time);

                            // Format hours and minutes to 12-hour format
                            let hours = messageTime.getHours();
                            const minutes = messageTime.getMinutes().toString().padStart(2, '0'); // Add leading zero if necessary
                            const ampm = hours >= 12 ? 'PM' : 'AM'; // Determine AM or PM
                            hours = hours % 12; // Convert to 12-hour format
                            hours = hours ? hours : 12; // The hour '0' should be '12'
                            const formattedTime = `${hours}:${minutes} ${ampm}`; // Combine hours, minutes, and AM/PM

                            const div = $('<div></div>')
                                .text(senderName + ': ' + message.message + ' ' + formattedTime);
                            // const div = $('<div></div>')
                            //     .text(senderName + ': ' + message.message + ' ' + message.time);

                            chatBox.append(div);
                            // Scroll to the bottom of the chat box after messages are loaded
                            // chatBox.animate({
                            //     scrollTop: chatBox.prop('scrollHeight')
                            // }, 500); // Smooth scroll
                        });
                    }

                });
            }




            // Send message in group chat
            $('#group-chat-form').submit(function(e) {
                e.preventDefault();
                const message = $('#group-chat-message').val();

                $.ajax({
                    url: 'send_group_message.php?roomName=' + encodeURIComponent(roomName), // Include roomName in URL
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        roomName: roomName,
                        message: message
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log("Response from the server: ", response); //log response to console
                        if (response.success) {
                            $('#group-chat-message').val(''); // Clear the input
                            loadRoomMessages(); // Reload the chat messages
                        } else {
                            console.error("Error sending message ", response.error); // log the error
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Log any AJAX errors
                    }
                });

            });

            $(window).on('pagehide', function() {
                alert('unload function triggered');
                navigator.sendBeacon('set_roomuser_offline.php?roomName=' + encodeURIComponent(roomName),
                    JSON.stringify({
                        user_name: "<?php echo htmlspecialchars($user_name); ?>"
                    })
                );
            });

            // //  Function to set user offline

            // $(window).on('beforeunload', function() {
            //     alert('Beforeunload event triggered.');
            //     console.log('Beforeunload event triggered.'); // Log to the console

            //     // Send an AJAX request to set the user offline
            //     $.ajax({
            //         url: 'set_roomuser_offline.php?roomName=' + encodeURIComponent(roomName), // Include roomName in URL
            //         type: 'POST',
            //         dataType: 'json',
            //         async: false, // Ensure the request completes before leaving
            //         data: {
            //             user_name: "<?php echo htmlspecialchars($user_name); ?>" // Send username
            //         },
            //         success: function(response) {
            //             console.log('User set offline successfully:', response);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error setting user offline:', status, error);
            //         }
            //     });
            // });
            // Load users and messages every few seconds
            setInterval(loadRoomUsers, 2000);
            setInterval(loadRoomMessages, 2000);

            // Initial load
            loadRoomUsers();
            loadRoomMessages();

        });
    </script>
</body>

</html>