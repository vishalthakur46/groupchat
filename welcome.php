<?php
SESSION_START();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: loginpage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ccd1d1, #f8f9f9);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .contain {
            width: 90%;
            /* Use percentage to ensure it adjusts on smaller screens */
            max-width: 1200px;
            /* Restrict the max-width to prevent exceeding screen limits */
            margin: 20px auto;
            height: 90vh;
        }

        .hidden {
            display: none;
        }

        .card {
            height: 85vh;
            overflow-y: auto;
            padding: 20px;
        }

        #online-users,
        #chat-box {
            max-height: 250px;
            overflow-y: auto;
        }

        .input-group {
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
        }
        .chat-msg-box {
    margin-top: 1rem;
    margin-bottom:1rem;
}
        #room-section input {
            margin-bottom: 10px;
        }

        hr {
            margin:1rem;
             border: 6;
             opacity: .25;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .contain {
                width: 95%;
                margin: 10px auto;
            }

            .card {
                height: 75vh;
            }

            .col-md-4,
            .col-md-8 {
                width: 100%;
                max-width: 100%;
                padding: 0 15px;
            }

            #create-room-section,
            #chat-box {
                width: 100%;
            }

            .input-group {
                display: flex;
                flex-direction: column;
            }

            .input-group input {
                margin-bottom: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
    <!-- <link rel="stylesheet" href="styles.css"> -->
</head>

<body>

    <div class="contain bg-white rounded shadow-sm">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">

                <div class="card">
                    <h1 class="">Welcome <?php echo $_SESSION['uname']; ?> </h1><span><a class="btn btn-primary " href="logout.php" role="button">LOG-OUT</a></span>

                    <hr>
                    <div class="container chat-msg-box">
                        <div class="row justify-content-center">
                            <div class="col-md-4"> <!-- User list section -->
                                <div>
                                    <h3 style= "font-size:1.2rem;">ChatAPP Users</h3>
                                    <ul style="height: 164px; overflow-y: scroll;" id="user-list" class="list-group">
                                        <!-- Online users will be loaded here -->
                                    </ul>

                                    <!-- Room List Section (Below User List) -->
                                    <h3 class="mt-4">Rooms</h3>
                                    <ul style="height: 130px; overflow-y: scroll;" id="room-list" class="list-group">
                                        <!-- Rooms will be loaded here -->
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8"> <!-- Chat box section -->
                                <h3 style= "font-size:1.2rem;">Messages</h3>
                                <div style="height: 300px; overflow-y: scroll;" id="chat-box">
                                    <!-- Chat messages will appear here -->
                                </div>

                                <form id="chat-form">
                                    <input type="hidden" id="receiver-id">
                                    <div class="input-group">
                                        <input type="text" id="chat-message" class="form-control" placeholder="Type a message" required>
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                                <br>
                                <!-- Room Creation Section (Initially Hidden) -->
                                <form id="room-section">
                                    <div class="mb-3 hidden" id="create-room-section">
                                        <label for="roomName" class="form-label">Create a Room</label>
                                        <input type="text" class="form-control  " id="roomName" name="roomName" placeholder="Enter room name /Join existing room">


                                    </div>

                                    <!-- Join Room Section (Initially Hidden) -->
                                    <!-- <div class="mb-3 hidden" id="join-room-section">
                                        <label for="room-id" class="form-label">Join a Room</label>
                                        <input type="text" class="form-control" id="roomName" name ="room" placeholder="Enter room ID" required>

                                    </div> -->
                                    <!-- Buttons for Room Actions -->
                                    <button type="submit" class="btn btn-primary" id="create-room-btn">Create/Join Room</button>
                                    <!-- <button class="btn btn-secondary" id="show-join-room">Join Room</button> -->



                            </div>
                            </form>
                            <br>


                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        let currentReceiverId = null;
                        // Function to load online users
                        function loadUsers() {
                            $('.active').addClass('active');

                            $.ajax({
                                url: 'fetch_online_users.php',
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    const userList = $('#user-list');

                                    console.log(data);
                                    userList.empty(); // Clear previous user list
                                    data.forEach(function(user) {
                                        const li = $('<li></li> ')
                                            .addClass('list-group-item')
                                            .text(user.uname)
                                            .attr('data-id', user.id); // Display just the username
                                        console.log(user.is_online);
                                        const statusDot = $('<span></span>').css({
                                            'height': '10px',
                                            'width': '10px',
                                            'border-radius': '50%',
                                            'display': 'inline-block',
                                            'margin-left': '10px',
                                            'background-color': user.is_online == 1 ? 'green' : 'red' // Green for online, Red for offline
                                        });

                                        li.append(statusDot);

                                        if (user.id == currentReceiverId) { // Check if this user is the currently selected one

                                            li.addClass('active').css({
                                                'background-color': '#007bff', // Blue background for active item
                                                'color': 'white' // White text for active item
                                            });
                                        }

                                        li.click(function() { // It sets the value of hidden input field #receiver-id to the clicked user's id 
                                            // Remove active class from all list items
                                            $('#user-list .list-group-item').removeClass('active').css({
                                                'background-color': '', // Reset background color
                                                'color': '' // Reset text color
                                            });

                                            $('#receiver-id').val(user.id);
                                            currentReceiverId = user.id;

                                            // Set active class for the clicked item
                                            li.addClass('active').css({
                                                'background-color': '#007bff', // Blue background for active item
                                                'color': 'white' // White text for active item
                                            });

                                            loadMessages(user.id); // Loads the chat with the selected user
                                        });

                                        userList.append(li); // Append the user to the list
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching online users:', error);
                                }
                            });
                        }
                        // Show Create Room Section
                        // $('#show-create-room').click(function() {
                        //     console.log()
                        //     $('#create-room-section').toggleClass('hidden'); // Toggle visibility

                        //     $('#join-room-section').addClass('hidden');

                        // });

                        // // Show Join Room Section
                        // $('#show-join-room').click(function() {

                        //     $('#join-room-section').toggleClass('hidden'); // Toggle visibility

                        //     $('#create-room-section').addClass('hidden');
                        // Hide Create Room section if visible
                        //        });


                        // function to load messages
                        function loadMessages(receiverId) {
                            // console.log(receiverId);
                            $.ajax({
                                url: 'fetch_messages.php',
                                type: 'POST',
                                data: {
                                    receiever_id: receiverId
                                },
                                datatype: 'json',
                                success: function(data) {
                                    const chatBox = $('#chat-box');
                                    chatBox.empty();
                                    console.log('Received messages data:', data);
                                    const arr = JSON.parse(data);
                                    console.log('Received messages data:', arr);
                                    //if (Array.isArray(arr)) {
                                    arr.forEach(function(message) {
                                        console.log('Processing message:', message);
                                        const div = $('<div></div>')
                                            .text(message.sender + ': ' + message.message);
                                        chatBox.append(div);
                                        // Scroll to the bottom of the chat box after messages are loaded
                                        // chatBox.animate({
                                        //     scrollTop: chatBox.prop('scrollHeight')
                                        // }, 500); // Smooth scroll
                                    });
                                    // }
                                },

                                error: function(xhr, status, error) {
                                    console.log('Error fetching messages:', error);
                                }
                            });
                        }
                        //Ajax request to load the rooms
                        $(document).ready(function() {
                            // Function to load rooms the user has joined
                            function loadRooms() {
                                $.ajax({
                                    url: 'fetch_rooms.php',
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        const roomList = $('#room-list');
                                        roomList.empty(); // Clear previous room list

                                        data.forEach(function(room) {
                                            const li = $('<li></li>')
                                                .addClass('list-group-item')
                                                .text(room.room_id)


                                            li.click(function() {
                                                window.location.href = `group_chat.php?roomName=${encodeURIComponent(room.room_id)}`;
                                            });

                                            roomList.append(li); // Append the room to the list
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error fetching rooms:', error);
                                    }
                                });
                            }

                            // Load rooms every 5 seconds
                            setInterval(loadRooms, 5000);
                            loadRooms(); // Initial load of rooms

                        });
                        //function to send a chat message

                        $('#chat-form').submit(function(e) {
                            e.preventDefault();
                            const message = $('#chat-message').val();
                            const receiverId = $('#receiver-id').val();


                            if (!receiverId) {
                                alert('Please select a user to send a message.');
                                return;
                            }

                            $.ajax({

                                url: 'send_message.php',
                                type: 'POST',
                                data: JSON.stringify({
                                    message: message,
                                    receiverId: receiverId
                                }),
                                contentType: 'application/json',
                                dataType: 'json',
                                success: function(data) {
                                    if (data.success) {
                                        $('#chat-message').val(''); //clear the message input
                                        loadMessages(receiverId); // Reload the chat
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log('Error sending message:', error);
                                }
                            });


                        });
                        $('#create-room-btn').click(function(e) {
                            e.preventDefault();
                            //check if the room name input field is visible

                            if ($('#create-room-section').hasClass('hidden')) {
                                // If the input field is hidden, show it
                                $('#create-room-section').removeClass('hidden');
                                return; // Exit early to prevent submission on first click
                            }
                            const roomName = $('#roomName').val();

                            //Ensure room name is not empty

                            if (!roomName) {
                                alert('please enter a room name. ');
                                return;
                            }

                            $.ajax({
                                url: 'create_room.php',
                                type: 'POST',
                                data: JSON.stringify({
                                    roomName: roomName
                                }),

                                success: function(response) {
                                    const res = JSON.parse(response);
                                    if (res.success) {
                                        $.ajax({
                                            url: 'group_chat.php', // second target file
                                            type: 'POST',
                                            data: JSON.stringify({
                                                roomName: roomName
                                            }),
                                            success: function(response) {
                                                console.log('response from the group_chat.php', response);
                                                //
                                            }
                                        });
                                        alert(res.message);

                                        //redirect to group chat page with the room name
                                        window.location.href = `group_chat.php?roomName=${encodeURIComponent(roomName)}`;
                                    } else {
                                        alert('Error creating room: ' + res.message);

                                    }
                                    console.log('Response:', response);

                                    //  further actions 


                                },
                                error: function(xhr, status, error) {
                                    console.log('Error sending message:', error);
                                }
                            });
                            // }
                        });



                        function refreshMessages() {
                            if (currentReceiverId) { // Only refresh if a receiver is selected
                                loadMessages(currentReceiverId);
                            }
                        }



                        // Load users every 5 seconds
                        setInterval(loadUsers, 5000);
                        loadUsers(); // Initial load of users
                        setInterval(refreshMessages, 5000);


                    });
                </script>


</body>

</html>