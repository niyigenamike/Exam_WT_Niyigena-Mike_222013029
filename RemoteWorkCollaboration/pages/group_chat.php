<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.chat-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 100%;
    padding: 20px;
    box-sizing: border-box;
}

h2 {
    margin-top: 0;
    text-align: center;
}

.messages {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 20px;
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

#messageForm {
    display: flex;
}

#messageInput {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px 0 0 5px;
    box-sizing: border-box;
}

#messageForm button {
    padding: 10px;
    border: none;
    background-color: #28a745;
    color: #fff;
    cursor: pointer;
    border-radius: 0 5px 5px 0;
}
</style>
</head>
<body>
    <div class="chat-container">
        <h2>GROUP CHAT</h2>
        <div class="messages" id="messages">
            <!-- Messages will be loaded here -->
        </div>
        <form id="messageForm">
            <input type="text" id="messageInput" placeholder="Send message" required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesContainer = document.getElementById('messages');

    // Function to fetch and display messages
    function fetchMessages() {
        fetch('fetchMessages.php')
            .then(response => response.json())
            .then(data => {
                messagesContainer.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');
                    messageElement.classList.add(message.sender === sessionId ? 'sender' : 'receiver');
                    
                    const emailElement = document.createElement('div');
                    emailElement.classList.add('email');
                    emailElement.textContent = message.email;

                    const textElement = document.createElement('div');
                    textElement.textContent = message.message;

                    messageElement.appendChild(emailElement);
                    messageElement.appendChild(textElement);
                    messagesContainer.appendChild(messageElement);
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Function to send a new message
    messageForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const message = messageInput.value;

        fetch('sendMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                fetchMessages();
            } else {
                alert('Error sending message');
            }
        })
        .catch(error => console.error('Error sending message:', error));
    });

    // Fetch messages initially and set interval to fetch messages every 2 seconds
    fetchMessages();
    setInterval(fetchMessages, 2000);
});

    </script>
</body>
</html>
