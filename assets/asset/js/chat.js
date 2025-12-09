const chatBox = document.getElementById("chat-box");
const input = document.getElementById("user-input");
const btn   = document.getElementById("send-btn");

const API_URL = "http://localhost:3000/chat";

/* ADD USER / BOT MESSAGE */
function addMessage(content, type = "bot") {
    const div = document.createElement("div");
    div.className = "message " + (type === "bot" ? "bot-message" : "user-message");

    if (type === "bot") {
        div.innerHTML = `
            <div class="bot-icon"><i class="fa-solid fa-robot" style="color:white;"></i></div>
            <div class="bot-text">${content}</div>
        `;
    } else {
        div.innerHTML = `
            <div class="user-text">${content}</div>
            <div class="user-icon"><i class="fa-solid fa-user" style="color:white;"></i></div>
        `;
    }

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

/* TYPING EFFECT */
function addTyping() {
    if (document.getElementById("typing")) return;

    const div = document.createElement("div");
    div.className = "message bot-message";
    div.id = "typing";

    div.innerHTML = `
        <div class="bot-icon"><i class="fa-solid fa-robot" style="color:white;"></i></div>
        <div class="bot-text">
            <div class="typing-wrapper">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>
        </div>
    `;

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function removeTyping() {
    const t = document.getElementById("typing");
    if (t) t.remove();
}

/* GREETING */
window.addEventListener("load", () => {
    addMessage("Halo! Saya Takumi AI 👋 Ada yang bisa saya bantu hari ini?");
});

/* SEND MESSAGE */
async function sendMessage() {
    const msg = input.value.trim();
    if (!msg) return;

    addMessage(msg, "user");
    input.value = "";

    addTyping();

    setTimeout(() => {
        removeTyping();
        addMessage("Server sedang sibuk.", "bot");
    }, 1200);
}

btn.addEventListener("click", sendMessage);
input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") sendMessage();
});

/* QUICK BUTTONS */
function sendQuick(text) {
    input.value = text;
    sendMessage();
}
