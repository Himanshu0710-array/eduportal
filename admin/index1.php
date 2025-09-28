<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assistant</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/9.1.2/marked.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e0eafc 0%, #764ba2 100%);
            color: var(--dark);
            line-height: 1.6;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 16px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 28px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gray);
            font-size: 14px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Main Content */
        .main {
            flex: 1;
            display: flex;
            padding: 20px 0;
            overflow: hidden;
        }

        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            height: 100%;
        }

        /* Chat Messages */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Message Styles */
        .message {
            display: flex;
            gap: 12px;
            max-width: 85%;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message.user {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user .message-avatar {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .assistant .message-avatar {
            background: linear-gradient(135deg, var(--secondary), #059669);
            color: white;
        }

        .message-content {
            background: white;
            padding: 16px 20px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            line-height: 1.5;
        }

        .user .message-content {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-bottom-right-radius: 4px;
        }

        .assistant .message-content {
            border-bottom-left-radius: 4px;
            border: 1px solid var(--gray-light);
        }

        .message-time {
            font-size: 12px;
            color: var(--gray);
            margin-top: 6px;
            text-align: right;
        }

        .user .message-time {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Welcome Screen */
        .welcome-screen {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }

        .welcome-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .welcome-subtitle {
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature-card {
            background: #f8fafc;
            padding: 20px;
            border-radius: var(--radius);
            text-align: left;
            border-left: 4px solid var(--primary);
        }

        .feature-icon {
            font-size: 24px;
            margin-bottom: 12px;
        }

        .feature-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .feature-desc {
            font-size: 14px;
            color: var(--gray);
        }

        /* Input Area */
        .input-container {
            padding: 20px;
            border-top: 1px solid var(--gray-light);
            background: #f8fafc;
        }

        .input-wrapper {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .chat-input {
            flex: 1;
            padding: 16px 20px;
            border: 1px solid var(--gray-light);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 16px;
            resize: none;
            max-height: 120px;
            transition: all 0.2s;
            background: white;
        }

        .chat-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .send-button {
            padding: 16px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .send-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .send-button:active {
            transform: translateY(0);
        }

        .send-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 16px 20px;
            background: white;
            border-radius: 18px;
            border: 1px solid var(--gray-light);
            margin-bottom: 20px;
            align-self: flex-start;
            max-width: 85%;
            border-bottom-left-radius: 4px;
        }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gray);
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
        .typing-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Message Content Styling */
        .message-content h1, 
        .message-content h2, 
        .message-content h3 {
            margin: 16px 0 8px 0;
            color: inherit;
        }

        .message-content p {
            margin-bottom: 12px;
        }

        .message-content ul, 
        .message-content ol {
            margin: 12px 0;
            padding-left: 24px;
        }

        .message-content li {
            margin: 6px 0;
        }

        .message-content blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 16px;
            margin: 16px 0;
            font-style: italic;
            color: var(--gray);
        }

        .message-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .message-content th, 
        .message-content td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--gray-light);
        }

        .message-content th {
            background: #f8fafc;
            font-weight: 600;
        }

        .message-content tr:last-child td {
            border-bottom: none;
        }

        .message-content code {
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .message-content pre {
            background: #1f2937 !important;
            color: #e5e7eb !important;
            padding: 16px !important;
            border-radius: 8px !important;
            overflow-x: auto !important;
            margin: 16px 0 !important;
            border-left: 4px solid var(--primary) !important;
        }

        .message-content pre code {
            background: transparent !important;
            padding: 0 !important;
            color: inherit !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }
            
            .chat-messages {
                padding: 16px;
            }
            
            .message {
                max-width: 95%;
            }
            
            .input-container {
                padding: 16px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-icon {
                font-size: 48px;
            }
            
            .welcome-title {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .header-content {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .message-avatar {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }
            
            .message-content {
                padding: 12px 16px;
            }
            
            .chat-input {
                padding: 12px 16px;
            }
            
            .send-button {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="logo-icon">🤖</div>
                    <div class="logo-text">AI Assistant</div>
                </div>
                <!-- <div class="user-info">
                    <div class="user-avatar"><?= strtoupper(substr($firstName, 0, 1)) ?></div>
                    <div>Hello, <?= htmlspecialchars($firstName) ?></div>
                </div> -->
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    <div class="welcome-screen" id="welcomeScreen">
                        <div class="welcome-icon">🤖</div>
                        <h1 class="welcome-title">Welcome to Your AI Assistant</h1>
                        <p class="welcome-subtitle">I'm here to help you with questions, coding, analysis, and conversations. Start by typing a message below!</p>
                        
                        <div class="features-grid">
                            <div class="feature-card">
                                <div class="feature-icon">💬</div>
                                <div class="feature-title">Conversational AI</div>
                                <div class="feature-desc">Have natural conversations and get helpful responses to your questions.</div>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">💻</div>
                                <div class="feature-title">Code Assistance</div>
                                <div class="feature-desc">Get help with programming, debugging, and code explanations.</div>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">📊</div>
                                <div class="feature-title">Data Analysis</div>
                                <div class="feature-desc">Receive insights and visualizations for your data questions.</div>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">🔍</div>
                                <div class="feature-title">Research Help</div>
                                <div class="feature-desc">Get explanations and summaries on complex topics.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="input-container">
                    <div class="input-wrapper">
                        <textarea class="chat-input" id="chatInput" rows="1" placeholder="Ask me anything..."></textarea>
                        <button class="send-button" id="sendButton">
                            <span>Send</span>
                            <span>↗</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        class ChatInterface {
            constructor() {
                this.isTyping = false;
                this.messageHistory = [];
                this.init();
            }

            init() {
                this.input = document.getElementById('chatInput');
                this.sendButton = document.getElementById('sendButton');
                this.chatMessages = document.getElementById('chatMessages');

                this.sendButton.addEventListener('click', () => this.sendMessage());
                this.input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        this.sendMessage();
                    }
                });
                
                this.input.addEventListener('input', () => {
                    this.input.style.height = 'auto';
                    this.input.style.height = Math.min(this.input.scrollHeight, 120) + 'px';
                });

                // Focus input on load
                this.input.focus();
            }

            addMessage(role, content, isRaw = false) {
                // Remove welcome screen if it's the first message
                document.getElementById('welcomeScreen')?.remove();
                
                const messageEl = document.createElement('div');
                messageEl.className = `message ${role}`;
                
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.textContent = role === 'user' ? 'You' : 'AI';
                
                const contentEl = document.createElement('div');
                contentEl.className = 'message-content';
                
                if (isRaw) {
                    contentEl.innerHTML = content;
                } else {
                    contentEl.innerHTML = content.replace(/\n/g, '<br>');
                }
                
                const timeEl = document.createElement('div');
                timeEl.className = 'message-time';
                timeEl.textContent = this.getCurrentTime();
                
                messageEl.appendChild(avatar);
                messageEl.appendChild(contentEl);
                contentEl.appendChild(timeEl);
                
                this.chatMessages.appendChild(messageEl);
                this.chatMessages.scrollTop = this.chatMessages.scrollHeight;

                // Apply syntax highlighting to code blocks
                if (role === 'assistant') {
                    messageEl.querySelectorAll('pre code').forEach((block) => {
                        Prism.highlightElement(block);
                    });
                }

                this.messageHistory.push({ role, content });
            }

            showTyping() {
                this.typingEl = document.createElement('div');
                this.typingEl.className = 'typing-indicator';
                this.typingEl.innerHTML = `
                    <div class="message-avatar">AI</div>
                    <div>AI is thinking</div>
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                `;
                this.chatMessages.appendChild(this.typingEl);
                this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
            }

            removeTyping() {
                this.typingEl?.remove();
            }

            async sendMessage() {
                if (this.isTyping) return;
                
                const message = this.input.value.trim();
                if (!message) return;

                this.addMessage('user', message);
                this.input.value = '';
                this.input.style.height = 'auto';

                this.isTyping = true;
                this.sendButton.disabled = true;
                this.showTyping();

                try {
                    const response = await fetch('ask.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ message })
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    this.removeTyping();

                    if (data.error) {
                        this.addMessage('assistant', `Sorry, there was an error: ${data.error}`);
                    } else {
                        const formattedReply = this.formatBotMessage(data.reply || 'Sorry, I received an empty response.');
                        this.addMessage('assistant', formattedReply, true);
                    }
                } catch (error) {
                    this.removeTyping();
                    console.error('Chat error:', error);
                    this.addMessage('assistant', 'Sorry, I\'m having trouble connecting right now. Please try again.');
                } finally {
                    this.isTyping = false;
                    this.sendButton.disabled = false;
                    this.input.focus();
                }
            }

            formatBotMessage(content) {
                // Process markdown-like formatting
                
                // Code blocks
                content = content.replace(/```(\w+)?\n?([\s\S]*?)```/g, (match, lang, code) => {
                    const language = lang || 'text';
                    return `<pre><code class="language-${language}">${this.escapeHtml(code.trim())}</code></pre>`;
                });

                // Inline code
                content = content.replace(/`([^`]+)`/g, '<code>$1</code>');

                // Tables
                content = content.replace(/\|(.+)\|\n\|[-\s|:]+\|\n((?:\|.+\|\n?)*)/g, (match, header, rows) => {
                    const headerCells = header.split('|').map(cell => cell.trim()).filter(cell => cell);
                    const rowData = rows.trim().split('\n').map(row => 
                        row.split('|').map(cell => cell.trim()).filter(cell => cell)
                    );

                    let tableHtml = '<table><thead><tr>';
                    headerCells.forEach(cell => {
                        tableHtml += `<th>${cell}</th>`;
                    });
                    tableHtml += '</tr></thead><tbody>';
                    
                    rowData.forEach(row => {
                        tableHtml += '<tr>';
                        row.forEach(cell => {
                            tableHtml += `<td>${cell}</td>`;
                        });
                        tableHtml += '</tr>';
                    });
                    
                    tableHtml += '</tbody></table>';
                    return tableHtml;
                });

                // Headings
                content = content.replace(/^### (.*$)/gim, '<h3>$1</h3>');
                content = content.replace(/^## (.*$)/gim, '<h2>$1</h2>');
                content = content.replace(/^# (.*$)/gim, '<h1>$1</h1>');

                // Bold and italic
                content = content.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
                content = content.replace(/\*([^*]+)\*/g, '<em>$1</em>');

                // Lists
                content = content.replace(/^\* (.+)$/gim, '<li>$1</li>');
                content = content.replace(/^\d+\. (.+)$/gim, '<li>$1</li>');
                content = content.replace(/(<li>.*<\/li>\n?)+/g, '<ul>$&</ul>');

                // Blockquotes
                content = content.replace(/^> (.*$)/gim, '<blockquote>$1</blockquote>');

                // Line breaks
                content = content.replace(/\n/g, '<br>');

                return content;
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            getCurrentTime() {
                const now = new Date();
                return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        }

        // Initialize chat when page loads
        document.addEventListener('DOMContentLoaded', () => {
            window.chat = new ChatInterface();
        });

        // Demo functions for testing
        window.demoTable = function() {
            const tableContent = `Here's a sample data table:

| Name | Age | City | Occupation |
|------|-----|------|------------|
| John | 25 | New York | Developer |
| Sarah | 30 | London | Designer |
| Mike | 28 | Tokyo | Engineer |
| Lisa | 35 | Paris | Manager |

This table shows employee information with proper formatting and styling.`;
            
            window.chat.addMessage('assistant', window.chat.formatBotMessage(tableContent), true);
        };

        window.demoCode = function() {
            const codeContent = `Here's a JavaScript example:

\`\`\`javascript
function calculateTotal(items) {
    let total = 0;
    items.forEach(item => {
        total += item.price * item.quantity;
    });
    return total;
}

// Usage example
const items = [
    { name: "Apple", price: 1.50, quantity: 3 },
    { name: "Banana", price: 0.75, quantity: 5 }
];

console.log(calculateTotal(items)); // Output: 8.25
\`\`\`

And here's some inline code: \`console.log("Hello World")\`

**Important:** This function calculates the total price including quantity.`;
            
            window.chat.addMessage('assistant', window.chat.formatBotMessage(codeContent), true);
        };
    </script>
</body>
</html>