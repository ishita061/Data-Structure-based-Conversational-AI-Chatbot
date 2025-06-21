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
            background: linear-gradient(to bottom right,rgb(104, 72, 142), #3a0ca3, #6a0572);
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
            line-height: 1.5;
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

        .code-block {
            background: rgba(0, 0, 0, 0.3);
            padding: 10px;
            border-radius: 5px;
            margin: 8px 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            border-left: 3px solid #c77dff;
        }

        .highlight {
            background: rgba(199, 125, 255, 0.2);
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <button class="logout-btn" onclick="logout()">Logout</button>

    <div class="header">
        <h1>Welcome to Lumen!</h1>
        <p>Your intelligent chatbot companion - Ask me about Data Structures & Algorithms!</p>
    </div>

    <div class="chat-container">
        <div class="chat-messages" id="chatMessages">
            <div class="bot-message">
                <div class="message-bubble">Hello! I'm Lumen. I can help you with Data Structures and Algorithms questions. Try asking me about binary search, sorting algorithms, or any other DSA topic! 🚀</div>
            </div>
        </div>

        <div class="input-area">
            <input type="text" id="messageInput" placeholder="Ask me about DSA topics..." onkeypress="handleEnter(event)">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        // DSA Knowledge Base
        const dsaKnowledge = {
            'binary search': {
                definition: "Binary Search is a searching algorithm that finds the position of a target value within a sorted array. It compares the target value to the middle element of the array.",
                timeComplexity: "O(log n)",
                spaceComplexity: "O(1) for iterative, O(log n) for recursive",
                example: `function binarySearch(arr, target) {
    let left = 0, right = arr.length - 1;
    
    while (left <= right) {
        let mid = Math.floor((left + right) / 2);
        
        if (arr[mid] === target) return mid;
        else if (arr[mid] < target) left = mid + 1;
        else right = mid - 1;
    }
    
    return -1; // Not found
}`
            },
            'linear search': {
                definition: "Linear Search is a simple searching algorithm that checks every element in the array sequentially until the target element is found or the array ends.",
                timeComplexity: "O(n)",
                spaceComplexity: "O(1)",
                example: `function linearSearch(arr, target) {
    for (let i = 0; i < arr.length; i++) {
        if (arr[i] === target) {
            return i;
        }
    }
    return -1; // Not found
}`
            },
            'bubble sort': {
                definition: "Bubble Sort is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order.",
                timeComplexity: "O(n²) worst case, O(n) best case",
                spaceComplexity: "O(1)",
                example: `function bubbleSort(arr) {
    for (let i = 0; i < arr.length - 1; i++) {
        for (let j = 0; j < arr.length - i - 1; j++) {
            if (arr[j] > arr[j + 1]) {
                [arr[j], arr[j + 1]] = [arr[j + 1], arr[j]];
            }
        }
    }
    return arr;
}`
            },
            'quick sort': {
                definition: "Quick Sort is a divide-and-conquer algorithm that picks a 'pivot' element and partitions the array around the pivot, then recursively sorts the sub-arrays.",
                timeComplexity: "O(n log n) average, O(n²) worst case",
                spaceComplexity: "O(log n)",
                example: `function quickSort(arr) {
    if (arr.length <= 1) return arr;
    
    const pivot = arr[Math.floor(arr.length / 2)];
    const left = arr.filter(x => x < pivot);
    const middle = arr.filter(x => x === pivot);
    const right = arr.filter(x => x > pivot);
    
    return [...quickSort(left), ...middle, ...quickSort(right)];
}`
            },
            'merge sort': {
                definition: "Merge Sort is a divide-and-conquer algorithm that divides the array into halves, sorts them separately, and then merges the sorted halves.",
                timeComplexity: "O(n log n)",
                spaceComplexity: "O(n)",
                example: `function mergeSort(arr) {
    if (arr.length <= 1) return arr;
    
    const mid = Math.floor(arr.length / 2);
    const left = mergeSort(arr.slice(0, mid));
    const right = mergeSort(arr.slice(mid));
    
    return merge(left, right);
}

function merge(left, right) {
    let result = [], i = 0, j = 0;
    
    while (i < left.length && j < right.length) {
        if (left[i] <= right[j]) {
            result.push(left[i++]);
        } else {
            result.push(right[j++]);
        }
    }
    
    return result.concat(left.slice(i)).concat(right.slice(j));
}`
            },
            'stack': {
                definition: "Stack is a linear data structure that follows the Last In First Out (LIFO) principle. Elements are added and removed from the same end called the 'top'.",
                timeComplexity: "O(1) for push, pop, peek operations",
                spaceComplexity: "O(n)",
                example: `class Stack {
    constructor() {
        this.items = [];
    }
    
    push(element) {
        this.items.push(element);
    }
    
    pop() {
        if (this.isEmpty()) return null;
        return this.items.pop();
    }
    
    peek() {
        return this.items[this.items.length - 1];
    }
    
    isEmpty() {
        return this.items.length === 0;
    }
}`
            },
            'queue': {
                definition: "Queue is a linear data structure that follows the First In First Out (FIFO) principle. Elements are added at the rear and removed from the front.",
                timeComplexity: "O(1) for enqueue, dequeue operations",
                spaceComplexity: "O(n)",
                example: `class Queue {
    constructor() {
        this.items = [];
    }
    
    enqueue(element) {
        this.items.push(element);
    }
    
    dequeue() {
        if (this.isEmpty()) return null;
        return this.items.shift();
    }
    
    front() {
        return this.items[0];
    }
    
    isEmpty() {
        return this.items.length === 0;
    }
}`
            },
            'linked list': {
                definition: "Linked List is a linear data structure where elements are stored in nodes, and each node contains data and a reference to the next node.",
                timeComplexity: "O(1) insertion/deletion at head, O(n) search",
                spaceComplexity: "O(n)",
                example: `class ListNode {
    constructor(data) {
        this.data = data;
        this.next = null;
    }
}

class LinkedList {
    constructor() {
        this.head = null;
    }
    
    insert(data) {
        const newNode = new ListNode(data);
        newNode.next = this.head;
        this.head = newNode;
    }
    
    search(data) {
        let current = this.head;
        while (current) {
            if (current.data === data) return true;
            current = current.next;
        }
        return false;
    }
}`
            },
            'binary tree': {
                definition: "Binary Tree is a hierarchical data structure where each node has at most two children, referred to as left child and right child.",
                timeComplexity: "O(log n) for balanced trees, O(n) for skewed trees",
                spaceComplexity: "O(n)",
                example: `class TreeNode {
    constructor(data) {
        this.data = data;
        this.left = null;
        this.right = null;
    }
}

class BinaryTree {
    constructor() {
        this.root = null;
    }
    
    inorderTraversal(node = this.root) {
        if (node) {
            this.inorderTraversal(node.left);
            console.log(node.data);
            this.inorderTraversal(node.right);
        }
    }
}`
            },
            'hash table': {
                definition: "Hash Table (Hash Map) is a data structure that implements an associative array, mapping keys to values using a hash function.",
                timeComplexity: "O(1) average for insert, delete, search",
                spaceComplexity: "O(n)",
                example: `class HashTable {
    constructor(size = 10) {
        this.size = size;
        this.table = new Array(size).fill(null).map(() => []);
    }
    
    hash(key) {
        let hash = 0;
        for (let i = 0; i < key.length; i++) {
            hash += key.charCodeAt(i);
        }
        return hash % this.size;
    }
    
    set(key, value) {
        const index = this.hash(key);
        this.table[index].push([key, value]);
    }
    
    get(key) {
        const index = this.hash(key);
        const bucket = this.table[index];
        for (let [k, v] of bucket) {
            if (k === key) return v;
        }
        return null;
    }
}`
            }
        };

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

        // Find DSA topic in message
        function findDSATopic(message) {
            const lowerMessage = message.toLowerCase();
            
            for (let topic in dsaKnowledge) {
                if (lowerMessage.includes(topic)) {
                    return topic;
                }
            }
            
            // Check for alternative names
            if (lowerMessage.includes('bfs') || lowerMessage.includes('breadth first')) return 'breadth first search';
            if (lowerMessage.includes('dfs') || lowerMessage.includes('depth first')) return 'depth first search';
            if (lowerMessage.includes('array') || lowerMessage.includes('list')) return 'array';
            
            return null;
        }

        // Generate DSA response
        function generateDSAResponse(topic) {
            const knowledge = dsaKnowledge[topic];
            if (!knowledge) return null;
            
            let response = `<div class="highlight">${topic.toUpperCase()}</div><br><br>`;
            response += `<strong>📝 Definition:</strong><br>${knowledge.definition}<br><br>`;
            response += `<strong>⏰ Time Complexity:</strong> ${knowledge.timeComplexity}<br>`;
            response += `<strong>💾 Space Complexity:</strong> ${knowledge.spaceComplexity}<br><br>`;
            response += `<strong>💻 Code Example:</strong><br>`;
            response += `<div class="code-block">${knowledge.example}</div>`;
            
            return response;
        }

        // Send message with DSA knowledge
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message) {
                addUserMessage(message);
                input.value = '';

                // Check if message contains DSA topic
                const dsaTopic = findDSATopic(message);
                
                let botResponse;
                if (dsaTopic) {
                    botResponse = generateDSAResponse(dsaTopic);
                }

                if (!botResponse) {
                    // Fallback responses for general queries
                    const generalResponses = [
                        "I specialize in Data Structures and Algorithms! Try asking me about binary search, sorting algorithms, stacks, queues, or trees. 🌳",
                        "I'm here to help with DSA concepts! What would you like to learn about? 📚",
                        "Ask me anything about algorithms or data structures - I'm ready to help! 💡",
                        "I can explain various DSA topics with examples and complexity analysis. What interests you? 🤔",
                        "Try asking: 'What is binary search?' or 'Explain merge sort' 🚀",
                        "I love discussing algorithms! Which one would you like to explore? ⚡"
                    ];
                    botResponse = generalResponses[Math.floor(Math.random() * generalResponses.length)];
                }

                // Typing effect
                const chatMessages = document.getElementById('chatMessages');
                const typingDiv = document.createElement('div');
                typingDiv.className = 'bot-message';
                typingDiv.innerHTML = `<div class="message-bubble">Lumen is thinking... 🤔</div>`;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;

                setTimeout(() => {
                    typingDiv.remove();
                    addBotMessage(botResponse);
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