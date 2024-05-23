<?php
include_once("./connection/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 </head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Group Chat</h1>
                <div class="card">
                    <div class="card-header">
                        <h4>Chat Messages</h4>
                    </div>
                    <div class="card-body">
                        <div id="messages" class="chat-container"></div>
                    </div>
                    <div class="card-footer">
                        <form id="messageForm" class="form-inline">
                            <input type="text" id="messageInput" class="form-control mr-2" placeholder="Send message" required>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-container {
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
        }

        .message .email {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .message.sender {
            background-color: #d1e7dd;
            text-align: right;
        }

        .message.receiver {
            background-color: #f8d7da;
            text-align: left;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            var sessionId = "<?php echo "1"; ?>";
            var sessionEmail = "<?php echo "mmmm"; ?>";

            function fetchMessages() {
                $.ajax({
                    url: 'fetchData/getChats.php',
                    method: 'GET',
                    success: function(data) {
                        $('#messages').html('');
                        data.forEach(function(message) {
                            var messageElement = $('<div class="message"></div>');
                            messageElement.addClass(message.sender == sessionId ? 'sender' : 'receiver');
                            
                            var emailElement = $('<div class="email"></div>').text(message.email);
                            var textElement = $('<div></div>').text(message.message);

                            messageElement.append(emailElement);
                            messageElement.append(textElement);
                            $('#messages').append(messageElement);
                        });
                        $('#messages').scrollTop($('#messages')[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred while fetching messages:", error);
                    }
                });
            }

            $('#messageForm').submit(function(e) {
                e.preventDefault();
                var message = $('#messageInput').val();

                $.ajax({
                    url: 'sendMessage.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ message: message }),
                    success: function(response) {
                        if (response.success) {
                            $('#messageInput').val('');
                            fetchMessages();
                        } else {
                            alert('Error sending message');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred while sending message:", error);
                    }
                });
            });

            fetchMessages();
            setInterval(fetchMessages, 2000);
        });
    </script>
</body>
</html>
