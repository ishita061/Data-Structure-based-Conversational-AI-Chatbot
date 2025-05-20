
// LOGIN FUNCTION 
function loginUser(event) {
  event.preventDefault();
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  if (username && password) {
    alert('Login successful');
    localStorage.setItem('username', username); // Save username
    window.location.href = 'chat.html';
  } else {
    alert('Please enter credentials');
  }
}

//SIGNUP FUNCTION
function signupUser() {
  const email = document.getElementById('email').value;
  const password = document.getElementById('signupPassword').value;
  if (email && password) {
    alert('Signup successful');
    window.location.href = 'login.html';
  } else {
    alert('Please fill all fields');
  }
}

//CREATE MESSAGE DOM
function createMessageElement(type, sender, text) {
  const messageDiv = document.createElement('div');
  messageDiv.className = `message ${type}`;

  const nameTag = document.createElement('div');
  nameTag.className = 'sender-name';
  nameTag.textContent = sender;

  const textNode = document.createElement('div');
  textNode.className = 'message-text';
  textNode.textContent = text;

  messageDiv.appendChild(nameTag);
  messageDiv.appendChild(textNode);
  return messageDiv;
//LOGIN FUNCTION
function loginUser(event) {
  event.preventDefault();
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  if (username && password) {
    alert('Login successful');
    localStorage.setItem('username', username); // Save username
    window.location.href = 'chat.html';
  } else {
    alert('Please enter credentials');
  }
}

//SIGNUP FUNCTION
function signupUser() {
  const email = document.getElementById('email').value;
  const password = document.getElementById('signupPassword').value;
  if (email && password) {
    alert('Signup successful');
    window.location.href = 'login.html';
  } else {
    alert('Please fill all fields');
  }
}

//CREATE MESSAGE DOM
function createMessageElement(type, sender, text) {
  const messageDiv = document.createElement('div');
  messageDiv.className = `message ${type}`;

  const nameTag = document.createElement('div');
  nameTag.className = 'sender-name';
  nameTag.textContent = sender;

  const textNode = document.createElement('div');
  textNode.className = 'message-text';
  textNode.textContent = text;

  messageDiv.appendChild(nameTag);
  messageDiv.appendChild(textNode);
  return messageDiv;
}

//BOT RESPONSE LOGIC
function getBotReply(userText) {
  // Dummy response logic - replace with AI logic if needed
  if (userText.toLowerCase().includes('hello')) {
    return "Hi there! I'm Lumen, your AI assistant.";
  }
  return "I'm here to help!";
}

// SEND MESSAGE FUNCTION
function sendMessage() {
  const input = document.getElementById('userInput');
  const text = input.value.trim();
  if (!text) return;

  const chatBox = document.getElementById('chatMessages');
  const username = localStorage.getItem('username') || 'You';

  // Show user message
  const userMsg = createMessageElement('user', username, text);
  chatBox.appendChild(userMsg);
  saveChat('user', username, text);

  // Bot reply
  setTimeout(() => {
    const replyText = getBotReply(text);
    const botMsg = createMessageElement('bot', 'Lumen', replyText);
    chatBox.appendChild(botMsg);
    saveChat('bot', 'Lumen', replyText);
    chatBox.scrollTop = chatBox.scrollHeight;
  }, 500);

  input.value = '';
  chatBox.scrollTop = chatBox.scrollHeight;
}

//SAVE CHAT HISTORY
function saveChat(type, sender, text) {
  const chatHistory = JSON.parse(localStorage.getItem('chatHistory')) || [];
  chatHistory.push({ type, sender, text });
  localStorage.setItem('chatHistory', JSON.stringify(chatHistory));
}

//LOAD CHAT HISTORY ON PAGE LOAD
document.addEventListener('DOMContentLoaded', () => {
  const chatBox = document.getElementById('chatMessages');
  const chatHistory = JSON.parse(localStorage.getItem('chatHistory')) || [];

  chatHistory.forEach(({ type, sender, text }) => {
    const msg = createMessageElement(type, sender, text);
    chatBox.appendChild(msg);
  });

  chatBox.scrollTop = chatBox.scrollHeight;
});

}

//BOT RESPONSE LOGIC
function getBotReply(userText) {
  // Dummy response logic - replace with AI logic if needed
  if (userText.toLowerCase().includes('hello')) {
    return "Hi there! I'm Lumen, your AI assistant.";
  }
  return "I'm here to help!";
}

// SEND MESSAGE FUNCTION
function sendMessage() {
  const input = document.getElementById('userInput');
  const text = input.value.trim();
  if (!text) return;

  const chatBox = document.getElementById('chatMessages');
  const username = localStorage.getItem('username') || 'You';

  // Show user message
  const userMsg = createMessageElement('user', username, text);
  chatBox.appendChild(userMsg);
  saveChat('user', username, text);

  // Bot reply
  setTimeout(() => {
    const replyText = getBotReply(text);
    const botMsg = createMessageElement('bot', 'Lumen', replyText);
    chatBox.appendChild(botMsg);
    saveChat('bot', 'Lumen', replyText);
    chatBox.scrollTop = chatBox.scrollHeight;
  }, 500);

  input.value = '';
  chatBox.scrollTop = chatBox.scrollHeight;
}

//SAVE CHAT HISTORY
function saveChat(type, sender, text) {
  const chatHistory = JSON.parse(localStorage.getItem('chatHistory')) || [];
  chatHistory.push({ type, sender, text });
  localStorage.setItem('chatHistory', JSON.stringify(chatHistory));
}

//LOAD CHAT HISTORY ON PAGE LOAD
document.addEventListener('DOMContentLoaded', () => {
  const chatBox = document.getElementById('chatMessages');
  const chatHistory = JSON.parse(localStorage.getItem('chatHistory')) || [];

  chatHistory.forEach(({ type, sender, text }) => {
    const msg = createMessageElement(type, sender, text);
    chatBox.appendChild(msg);
  });

  chatBox.scrollTop = chatBox.scrollHeight;
});
