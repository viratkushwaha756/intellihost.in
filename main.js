document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.getElementById('search-btn');
    const searchInput = document.getElementById('search-input');

    if (searchButton && searchInput) {
        searchButton.addEventListener('click', function () {
            const query = searchInput.value.trim();
            if (query) {
                console.log('Searching for:', query);
            } else {
                alert("Please enter a search term.");
            }
        });

        searchInput.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                searchButton.click();
            }
        });
    }

    const menuButton = document.getElementById('menu-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');
    if (menuButton && dropdownMenu) {
        menuButton.addEventListener('click', function () {
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.getElementById('close-btn').addEventListener('click', function () {
            dropdownMenu.style.display = 'none';
        });

        document.addEventListener('click', function (event) {
            if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }

    const authModal = document.getElementById('auth-modal');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const closeModalButtons = document.querySelectorAll('.close-btn');
    
    document.getElementById('login-link')?.addEventListener('click', function () {
        authModal.style.display = 'flex';
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
    });
    
    document.getElementById('signup-link')?.addEventListener('click', function () {
        authModal.style.display = 'flex';
        signupForm.style.display = 'block';
        loginForm.style.display = 'none';
    });
    
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            authModal.style.display = 'none';
        });
    });
    
    const modalState = localStorage.getItem('modalState');
    if (modalState === 'signup') {
        setTimeout(function () {
            authModal.style.display = 'flex';
            signupForm.style.display = 'block';
            loginForm.style.display = 'none';
        }, 4000);
    }
    
    if (document.getElementById('signup-link')) {
        document.getElementById('signup-link').addEventListener('click', function () {
            localStorage.setItem('modalState', 'signup');
            setTimeout(function () {
                authModal.style.display = 'flex';
                signupForm.style.display = 'block';
                loginForm.style.display = 'none';
            }, 2000);
        });
    }
    
    

    const chatbotContainer = document.getElementById('chatbot-container');
    const openChatbotButton = document.getElementById('open-chatbot');
    const closeChatbotButton = document.getElementById('close-chatbot');
    
    openChatbotButton?.addEventListener('click', function () {
        chatbotContainer.style.display = 'block';
    });
    
    closeChatbotButton?.addEventListener('click', function () {
        chatbotContainer.style.display = 'none';
    });
    
    const sendMessageButton = document.getElementById('send-message');
    const userInputField = document.getElementById('user-input');
    const chatbotMessages = document.getElementById('chatbot-messages');
    
    function sendMessage() {
        const userMessage = userInputField.value.trim();
        if (userMessage) {
            appendUserMessage(userMessage);
            sendMessageToAPI(userMessage);
            userInputField.value = '';
        }
    }
    
    userInputField?.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });
    
    function appendUserMessage(message) {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('chatbot-message', 'user');
        messageContainer.innerHTML = `<p>${message}</p>`;
        chatbotMessages.appendChild(messageContainer);
    }
    
    function sendMessageToAPI(message) {
        let botResponse = "Sorry, I encountered an error. Please contact the manager for more details at: +123-456-7890.";
    
        const lowerCaseMessage = message.toLowerCase();
    
        if (lowerCaseMessage.includes("hello")) {
            botResponse = "Hi! How can I assist you today?";
        } else if (lowerCaseMessage.includes("tell me about intelli host")) {
            botResponse = "IntelliHost provides excellent web hosting services, cloud solutions, and 24/7 customer support.";
        } else if (lowerCaseMessage.includes("contact")) {
            botResponse = "You can reach us at +123-456-7890 for any inquiries or support.";
        } else if (lowerCaseMessage.includes("intelli host pg home") || lowerCaseMessage.includes("pg home services")) {
            botResponse = "Intelli Host is a PG home that offers a variety of facilities to make your stay comfortable. Here are some key services we provide:\n- High-speed WiFi\n- 24/7 Security\n- Best rooms with premium amenities\n- Tasty and nutritious food\n- Entertainment options for relaxation\n- Daily cleaning and housekeeping\n- Safe water facilities\n- Reliable electricity";
        } else if (lowerCaseMessage.includes("types of rooms")) {
            botResponse = "I don’t have exact details about the room types, but I can connect you to the manager for more information. Would you like to talk to them?";
        } else if (lowerCaseMessage.includes("kitchen for cooking")) {
            botResponse = "We offer delicious meals, but if you have specific cooking needs, I suggest speaking to the manager for more details.";
        } else if (lowerCaseMessage.includes("security measures")) {
            botResponse = "Intelli Host ensures 24/7 security with round-the-clock surveillance to keep everyone safe.";
        } else if (lowerCaseMessage.includes("power backup")) {
            botResponse = "Yes, we have reliable power backup to avoid any interruptions.";
        } else if (lowerCaseMessage.includes("how often do you clean the rooms")) {
            botResponse = "Housekeeping is done daily to maintain cleanliness and hygiene.";
        } else if (lowerCaseMessage.includes("laundry services")) {
            botResponse = "I don’t have specific information on laundry, but I can get you in touch with the manager for details. Would you like that?";
        } else if (lowerCaseMessage.includes("maintenance help")) {
            botResponse = "For maintenance-related issues, the manager will assist you. You can contact them directly.";
        } else if (lowerCaseMessage.includes("parking area")) {
            botResponse = "I’m not sure about the parking arrangements, but the manager will provide you with all the necessary details. Would you like to talk to them?";
        } else if (lowerCaseMessage.includes("how to contact manager")) {
            botResponse = "You can contact the manager at: +123-456-7890 for any further inquiries.";
        }
    
        setTimeout(() => {
            appendBotMessage(botResponse);
        }, 1000);
    }
    
    function appendBotMessage(message) {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('chatbot-message', 'bot');
        messageContainer.innerHTML = `<div class="bot-avatar"><img src="image/ai.png" class="bot-avatar-img" /></div><p>${message}</p>`;
        chatbotMessages.appendChild(messageContainer);
    }
    
    sendMessageButton?.addEventListener('click', sendMessage);
    
    userInputField?.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

    const video = document.getElementById('myVideo');
    const playButton = document.getElementById('playButton');

    playButton.addEventListener('click', function() {
        if (video.paused) {
            video.play();
            playButton.style.display = 'none';
        } else {
            video.pause();
            playButton.style.display = 'block';
        }
    });

    video.addEventListener('click', function() {
        if (!video.paused) {
            video.pause();
            playButton.style.display = 'block';
        }
    });

    video.addEventListener('pause', function() {
        playButton.style.display = 'block';
    });

    video.addEventListener('ended', function() {
        playButton.style.display = 'block';
    });
});




var typed = new Typed("#puneText", {
    strings: ["Pune......!"],
    typeSpeed: 200,        
    backSpeed: 300,        
    backDelay: 1000,       
    loop: true             
});



const images = document.querySelectorAll('.template-images img');

images.forEach(image => {
    image.addEventListener('click', function() {
        this.classList.toggle('zoomed');
    });
});



