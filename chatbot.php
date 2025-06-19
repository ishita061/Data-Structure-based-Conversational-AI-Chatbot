<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumen Chatbot</title>

    <!-- Emoji Button CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #1a1a2e, #3a0ca3, #6a0572);
            color: #f5f5f5;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding: 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
        }

        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .input-area {
            display: flex;
            gap: 10px;
        }

        .input-area input {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .input-area button {
            padding: 15px 20px;
            background: #c77dff;
            border: none;
            border-radius: 25px;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #ff6b6b;
            border: none;
            border-radius: 20px;
            color: white;
            cursor: pointer;
        }

        /* Message Bubbles */
        .user-message {
            display: flex;
            justify-content: flex-end;
            margin: 10px 0;
        }

        .user-message .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 18px;
            border-radius: 20px 20px 5px 20px;
            max-width: 70%;
            margin-right: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .bot-message {
            display: flex;
            justify-content: flex-start;
            margin: 10px 0;
        }

        .bot-message .message-bubble {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 18px;
            border-radius: 20px 20px 20px 5px;
            max-width: 70%;
            margin-left: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-message::before {
            content: "You";
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            margin-right: 8px;
            align-self: flex-end;
            margin-bottom: 5px;
        }

        .bot-message::after {
            content: "Lumen";
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            margin-left: 8px;
            align-self: flex-end;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <button class="logout-btn" onclick="logout()">Logout</button>

    <div class="header">
        <h1>Welcome to Lumen!</h1>
        <p>Your intelligent chatbot companion</p>
    </div>

    <div class="chat-container">
        <div class="chat-messages" id="chatMessages">
            <div class="bot-message">
                <div class="message-bubble">Hello! I'm Lumen. How can I help you today?</div>
            </div>
        </div>

        <div class="input-area">
            <input type="text" id="messageInput" placeholder="Type your message..." onkeypress="handleEnter(event)">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        // Add user message
        function addUserMessage(message) {
            const chatMessages = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'user-message';
            messageDiv.innerHTML = `<div class="message-bubble">${message}</div>`;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Add bot message
        function addBotMessage(message) {
            const chatMessages = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'bot-message';
            messageDiv.innerHTML = `<div class="message-bubble">${message}</div>`;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Send message with typing effect and random response
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message) {
                addUserMessage(message);
                input.value = '';

                const botReplies = [
                    "I'm here to help!",
                    "That's interesting!",
                    "Can you tell me more?",
                    "I see. Go on...",
                    "Thanks for your message! 😊",
                    "Let me think... 🤔",
                    "Tell me what you'd like to know.",
                    "Hmm... That's something!"
                ];

                const randomReply = botReplies[Math.floor(Math.random() * botReplies.length)];

                // Typing effect
                const chatMessages = document.getElementById('chatMessages');
                const typingDiv = document.createElement('div');
                typingDiv.className = 'bot-message';
                typingDiv.innerHTML = `<div class="message-bubble">Lumen is typing...</div>`;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;

                setTimeout(() => {
                    typingDiv.remove();
                    addBotMessage(randomReply);
                }, 1000 + Math.random() * 1000);
            }
        }

        function handleEnter(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }

        // 🎤 Voice input setup
        const micButton = document.createElement('button');
        micButton.textContent = '🎤';
        micButton.style.borderRadius = '50%';
        micButton.style.padding = '0 15px';
        micButton.style.fontSize = '18px';
        micButton.style.cursor = 'pointer';
        micButton.style.background = '#ffd6ff';
        micButton.onclick = startVoiceInput;
        document.querySelector('.input-area').appendChild(micButton);

        function startVoiceInput() {
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.start();

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                document.getElementById('messageInput').value = transcript;
                sendMessage();
            };

            recognition.onerror = (event) => {
                alert('Voice input error: ' + event.error);
            };
        }

        // 😊 Emoji picker setup
        const emojiBtn = document.createElement('button');
        emojiBtn.textContent = '😊';
        emojiBtn.style.fontSize = '18px';
        emojiBtn.style.cursor = 'pointer';
        emojiBtn.style.background = '#e0aaff';
        emojiBtn.style.borderRadius = '50%';
        emojiBtn.style.padding = '0 15px';
        document.querySelector('.input-area').appendChild(emojiBtn);

        const picker = new EmojiButton();
        emojiBtn.addEventListener('click', () => {
            picker.togglePicker(emojiBtn);
        });

        picker.on('emoji', emoji => {
            const input = document.getElementById('messageInput');
            input.value += emoji;
            input.focus();
        });
    </script>
</body>
</html>
