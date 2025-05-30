<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Эрүүл Мэндийн VR Контент')</title>
    <meta name="description" content="Эрүүл мэндийн салбарт зориулсан хамгийн чанартай VR загварууд">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3a86ff',
                        secondary: '#4cc9f0',
                        accent: '#7209b7',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Custom styles */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination li.active span {
            background-color: var(--primary);
            color: white;
        }

        .pagination li a:hover {
            background-color: #f0f0f0;
        }

        /* Chatbot styles */
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .chatbot-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3a86ff, #7209b7);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .chatbot-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .chatbot-panel {
            position: absolute;
            bottom: 75px;
            right: 0;
            width: 350px;
            height: 500px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        .chatbot-panel.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }

        .chatbot-header {
            padding: 16px;
            background: linear-gradient(135deg, #3a86ff, #4cc9f0);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chatbot-messages {
            flex-grow: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .message {
            max-width: 80%;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.4;
        }

        .bot-message {
            background-color: #f0f2f5;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .user-message {
            background-color: #3a86ff;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .chatbot-input {
            padding: 16px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 8px;
        }

        .chatbot-input input {
            flex-grow: 1;
            padding: 10px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 24px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .chatbot-input input:focus {
            border-color: #3a86ff;
        }

        .chatbot-input button {
            background-color: #3a86ff;
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chatbot-input button:hover {
            background-color: #2a76ef;
        }

        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 8px 12px;
            background-color: #f0f2f5;
            border-radius: 12px;
            width: fit-content;
            align-self: flex-start;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background-color: #888;
            border-radius: 50%;
            animation: typing-animation 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing-animation {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-gradient-to-r from-primary to-secondary text-white shadow-md">
        <div class="container mx-auto px-4">
            <nav class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold">HealthVR</a>

                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-white/80">Нүүр</a>
                    <a href="{{ route('vr-content.featured') }}" class="hover:text-white/80">Онцлох</a>
                    <a href="{{ route('vr-content.new') }}" class="hover:text-white/80">Шинэ загварууд</a>
                    <a href="{{ route('about') }}" class="hover:text-white/80">Тухай</a>
                    <a href="{{ route('contact') }}" class="hover:text-white/80">Холбоо барих</a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden py-4 md:hidden">
                <a href="{{ route('home') }}" class="block py-2">Нүүр</a>
                <a href="{{ route('vr-content.featured') }}" class="block py-2">Онцлох</a>
                <a href="{{ route('vr-content.new') }}" class="block py-2">Шинэ загварууд</a>
                <a href="{{ route('about') }}" class="block py-2">Тухай</a>
                <a href="{{ route('contact') }}" class="block py-2">Холбоо барих</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        HealthVR
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <p class="text-gray-400 mb-4">Бид эрүүл мэндийн салбарт хэрэглэгддэг 3D VR загваруудыг нэгтгэн хүргэж байна. Оюутан, багш, эмч нар, эрүүл мэндийн мэргэжилтнүүдэд зориулагдсан.</p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        Ангилал
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <div class="space-y-2">
                        @foreach(\App\Models\Category::take(5)->get() as $footerCategory)
                            <a href="{{ route('vr-content.category', $footerCategory->slug) }}" class="block text-gray-400 hover:text-white">{{ $footerCategory->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        Холбоосууд
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block text-gray-400 hover:text-white">Нүүр</a>
                        <a href="{{ route('vr-content.featured') }}" class="block text-gray-400 hover:text-white">Онцлох</a>
                        <a href="{{ route('vr-content.new') }}" class="block text-gray-400 hover:text-white">Шинэ загварууд</a>
                        <a href="{{ route('about') }}" class="block text-gray-400 hover:text-white">Тухай</a>
                        <a href="{{ route('contact') }}" class="block text-gray-400 hover:text-white">Холбоо барих</a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4 relative inline-block">
                        Холбоо барих
                        <span class="absolute bottom-[-8px] left-0 w-1/2 h-[2px] bg-accent"></span>
                    </h3>
                    <div class="space-y-2">
                        <a href="mailto:info@healthvr.mn" class="block text-gray-400 hover:text-white">
                            <i class="fas fa-envelope mr-2"></i> info@healthvr.mn
                        </a>
                        <a href="tel:+97699112233" class="block text-gray-400 hover:text-white">
                            <i class="fas fa-phone mr-2"></i> +976 99112233
                        </a>
                        <p class="text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i> Улаанбаатар хот
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} HealthVR - Эрүүл мэндийн VR агуулга. Бүх эрх хуулиар хамгаалагдсан.</p>
            </div>
        </div>
    </footer>

    <!-- Chatbot -->
    <div class="chatbot-container">
        <div class="chatbot-button" id="chatbot-toggle">
            <i class="fas fa-comments text-white text-2xl"></i>
        </div>

        <div class="chatbot-panel" id="chatbot-panel">
            <div class="chatbot-header">
                <h3 class="font-bold text-lg">HealthVR Туслах</h3>
                <button id="close-chatbot" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="chatbot-messages" id="chatbot-messages">
                <div class="message bot-message">
                    Сайн байна уу! HealthVR-ийн туслахад тавтай морил. Би танд хэрхэн туслах вэ?
                </div>
            </div>

            <div class="chatbot-input">
                <input type="text" id="user-input" placeholder="Энд бичнэ үү..." />
                <button id="send-message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

<!-- Chatbot script section to update in your app.blade.php -->
<script>
    // Chatbot functionality
// Chatbot functionality
// Chatbot functionality
const chatbotToggle = document.getElementById('chatbot-toggle');
const chatbotPanel = document.getElementById('chatbot-panel');
const closeButton = document.getElementById('close-chatbot');
const messagesContainer = document.getElementById('chatbot-messages');
const userInput = document.getElementById('user-input');
const sendButton = document.getElementById('send-message');
let isSending = false;

// CSRF Token for Laravel
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Simplified conversation history with clearer system prompt
let conversationHistory = [
    {
        role: "system",
        content: "Та HealthVR-ийн туслах. Эрүүл мэндийн VR-ийн талаар лавлах мэдээлэл өгнө. Богино, энгийн хариултууд өгнө. Эмчилгээний зөвлөгөө хэрэгтэй бол 'Эмчилгээний зөвлөгөө авахыг хүсвэл эмчтэй холбогдоно уу' гэж хариулна."
    },
    {
        role: "assistant",
        content: "Сайн байна уу! HealthVR-ийн туслахад тавтай морил. Би танд хэрхэн туслах вэ?"
    }
];

// Clear conversation history (except system message)
const resetConversation = () => {
    const systemMessage = conversationHistory.find(msg => msg.role === "system");
    conversationHistory = [
        systemMessage,
        {
            role: "assistant",
            content: "Сайн байна уу! HealthVR-ийн туслахад тавтай морил. Би танд хэрхэн туслах вэ?"
        }
    ];

    // Clear UI messages except the first bot message
    while (messagesContainer.children.length > 1) {
        messagesContainer.removeChild(messagesContainer.lastChild);
    }
};

// Toggle chatbot panel
chatbotToggle.addEventListener('click', () => {
    chatbotPanel.classList.toggle('active');
});

// Close chatbot panel
closeButton.addEventListener('click', () => {
    chatbotPanel.classList.remove('active');
    // Optional: Reset conversation when closing
    // resetConversation();
});

// Add message to UI
const addMessage = (message, type) => {
    const messageElement = document.createElement('div');
    messageElement.className = `message ${type}-message`;
    messageElement.textContent = message;
    messagesContainer.appendChild(messageElement);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
};

// Show typing indicator
const showTypingIndicator = () => {
    const typingIndicator = document.createElement('div');
    typingIndicator.className = 'typing-indicator';
    typingIndicator.id = 'typing-indicator';

    for (let i = 0; i < 3; i++) {
        const dot = document.createElement('div');
        dot.className = 'typing-dot';
        typingIndicator.appendChild(dot);
    }

    messagesContainer.appendChild(typingIndicator);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
};

// Remove typing indicator
const removeTypingIndicator = () => {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
};

// Clean and format the bot response
const cleanBotResponse = (response) => {
    // Remove repeated phrases about consulting a doctor
    const consultPhrase = "эмчилгээний зөвлөгөө авахыг хүсвэл эмчтэй холбогдоно уу";

    // If the response contains this phrase multiple times, keep only the first instance
    const parts = response.split(consultPhrase);
    if (parts.length > 2) {
        return parts[0] + consultPhrase;
    }

    // Fix any incomplete sentences at the end
    let cleaned = response.trim();
    if (cleaned.endsWith('э') || cleaned.endsWith('...')) {
        // Find the last complete sentence
        const sentences = cleaned.split('.');
        sentences.pop(); // Remove the incomplete sentence
        cleaned = sentences.join('.') + '.';
    }

    return cleaned;
};

// Send message function
const sendMessage = async () => {
    const userMessage = userInput.value.trim();
    if (!userMessage || isSending) return;

    isSending = true;

    // Add user message to UI
    addMessage(userMessage, 'user');
    userInput.value = '';
    showTypingIndicator();

    // Add user message to conversation history
    conversationHistory.push({ role: "user", content: userMessage });

    try {
        const response = await fetch('/chatbot/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                messages: conversationHistory
            })
        });

        const data = await response.json();

        // Handle API errors
        if (!response.ok) {
            throw new Error(data.error || "API request failed");
        }

        // Properly extract and clean the bot's response
        if (data.choices && data.choices[0] && data.choices[0].message) {
            let botMessage = data.choices[0].message.content;

            // Clean the response
            botMessage = cleanBotResponse(botMessage);

            // Add bot response to UI
            addMessage(botMessage, 'bot');

            // Add clean bot response to conversation history
            conversationHistory.push({
                role: "assistant",
                content: botMessage
            });

            // If the conversation is getting too long, trim it
            if (conversationHistory.length > 10) {
                // Keep the system message and remove old messages
                const systemMessage = conversationHistory.find(msg => msg.role === "system");
                conversationHistory = [systemMessage, ...conversationHistory.slice(-9)];
            }
        } else {
            throw new Error("Invalid API response format");
        }

    } catch (error) {
        console.error("Error:", error);
        addMessage(`Алдаа гарлаа: ${error.message}`, 'bot');
    } finally {
        removeTypingIndicator();
        isSending = false;
    }
};

// Add a reset button to the chatbot header (optional)
const addResetButton = () => {
    const resetButton = document.createElement('button');
    resetButton.innerHTML = '<i class="fas fa-redo"></i>';
    resetButton.className = 'reset-button ml-2 text-white hover:text-gray-200';
    resetButton.title = 'Хөөрөлдөөнийг шинэчлэх';
    resetButton.addEventListener('click', resetConversation);

    const header = document.querySelector('.chatbot-header');
    header.insertBefore(resetButton, document.getElementById('close-chatbot'));
};

// Initialize
sendButton.addEventListener('click', sendMessage);
userInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Optional: Add the reset button
// addResetButton();
</script>
</body>
</html>
