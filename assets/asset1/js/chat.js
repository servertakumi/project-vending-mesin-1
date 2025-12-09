const chatBox = document.getElementById("chat-box");
const input = document.getElementById("user-input");
const btn = document.getElementById("send-btn");
const API_URL = "http://localhost:3000/chat";

/* Tambah pesan */
function addMessage(content, type = "bot") {
    const div = document.createElement("div");
    div.className = `flex items-start gap-3 message-slide-in ${type === "user" ? "flex-row-reverse user" : "bot"}`;

    // HTML icon + bubble
    div.innerHTML = type === "bot" ? `
        <div class="w-10 h-10 bg-gradient-to-br from-[#27AAE1] to-[#0850C8] rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
            <i class="fas fa-robot text-white text-sm"></i>
        </div>
        <div class="bg-gradient-to-r from-[#E1F0FF] to-[#B0D4FF] text-black rounded-2xl rounded-tl-md px-5 py-4 shadow-md max-w-2xl border border-blue-300">
            <p class="text-base leading-relaxed">${content}</p>
        </div>
    ` : `
        <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
            <i class="fas fa-user text-white text-sm"></i>
        </div>
        <div class="bg-gradient-to-r from-[#27AAE1] to-[#0850C8] text-white rounded-2xl rounded-tr-md px-5 py-4 shadow-md max-w-2xl border border-blue-300">
            <p class="text-base leading-relaxed">${content}</p>
        </div>
    `;

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}

/* Typing animation sederhana */
function addTyping() {
    addMessage("...", "bot");
}

/* Remove typing (hapus terakhir jika berupa '...') */
function removeTyping() {
    const last = chatBox.lastChild;
    if(last && last.querySelector('p')?.textContent === "...") last.remove();
}

/* Kirim pesan ke server */
async function sendMessage() {
    const msg = input.value.trim();
    if(!msg) return;
    addMessage(msg, "user");
    input.value = "";
    addTyping();

    try {
        const res = await fetch(API_URL, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ message: msg })
        });
        const data = await res.json();
        removeTyping();
        addMessage(data.reply, "bot");
    } catch (err) {
        removeTyping();
        addMessage("❌ Terjadi kesalahan koneksi server.", "bot");
    }
}

/* Button & Enter */
btn.addEventListener("click", sendMessage);
input.addEventListener("keydown", e => { if(e.key==="Enter") sendMessage(); });

/* Greeting otomatis */
window.addEventListener("load", async () => {
    try {
        const res = await fetch("http://localhost:3000/greeting");
        const data = await res.json();
        addMessage(data.reply, "bot");
    } catch {
        addMessage("Halo! Saya AI Assistant Takumi.", "bot");
    }
});
// Quick send function for popular questions
function sendQuick(text) {
  const input = document.getElementById('user-input');
  input.value = text;
  sendMessage();
}

// Simulate sending message and AI response
document.getElementById('send-btn').addEventListener('click', sendMessage);
document.getElementById('user-input').addEventListener('keypress', function(e){
  if(e.key === 'Enter') sendMessage();
});

function sendMessage() {
  const input = document.getElementById('user-input');
  const chatBox = document.getElementById('chat-box');
  const message = input.value.trim();
  if(!message) return;

  // User message
  const userDiv = document.createElement('div');
  userDiv.textContent = message;
  userDiv.style.background = '#0077cc';
  userDiv.style.color = '#fff';
  userDiv.style.padding = '8px 12px';
  userDiv.style.borderRadius = '15px';
  userDiv.style.alignSelf = 'flex-end';
  userDiv.style.maxWidth = '70%';
  chatBox.appendChild(userDiv);
  chatBox.scrollTop = chatBox.scrollHeight;

  input.value = '';

  // AI loading animation
  const loading = document.createElement('div');
  loading.style.display = 'flex';
  loading.style.alignItems = 'center';
  loading.style.gap = '5px';
  loading.style.color = '#0077cc';
  loading.style.fontWeight = 'bold';
  loading.innerHTML = `
    <span>AI sedang mengetik</span>
    <span style="display:flex; gap:2px;">
      <span style="width:6px; height:6px; background:#0077cc; border-radius:50%; animation:bounce 0.6s infinite 0s;"></span>
      <span style="width:6px; height:6px; background:#0077cc; border-radius:50%; animation:bounce 0.6s infinite 0.2s;"></span>
      <span style="width:6px; height:6px; background:#0077cc; border-radius:50%; animation:bounce 0.6s infinite 0.4s;"></span>
    </span>
  `;
  chatBox.appendChild(loading);
  chatBox.scrollTop = chatBox.scrollHeight;

  // Simulate AI response after 1.5s
  setTimeout(() => {
    loading.remove();
    const aiDiv = document.createElement('div');
    aiDiv.textContent = "Ini contoh jawaban AI untuk: " + message;
    aiDiv.style.background = '#e0f0ff';
    aiDiv.style.color = '#0077cc';
    aiDiv.style.padding = '8px 12px';
    aiDiv.style.borderRadius = '15px';
    aiDiv.style.alignSelf = 'flex-start';
    aiDiv.style.maxWidth = '70%';
    chatBox.appendChild(aiDiv);
    chatBox.scrollTop = chatBox.scrollHeight;
  }, 1500);
}
/* ===== Loading typing animation modern ===== */
function addTyping() {
  const div = document.createElement("div");
  div.className = "message bot-message";
  div.id = "typing";
  div.innerHTML = `
    <div class="bot-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <g fill="none">
          <path fill="#00a3ff" d="M9.107 5.448c.598-1.75 3.016-1.803 3.725-.159l.06.16l.807 2.36a4 4 0 0 0 2.276 2.411l.217.081l2.36.806c1.75.598 1.803 3.016.16 3.725l-.16.06l-2.36.807a4 4 0 0 0-2.412 2.276l-.081.216l-.806 2.361c-.598 1.75-3.016 1.803-3.724.16l-.062-.16l-.806-2.36a4 4 0 0 0-2.276-2.412l-.216-.081l-2.36-.806c-1.751-.598-1.804-3.016-.16-3.724l.16-.062l2.36-.806A4 4 0 0 0 8.22 8.025l.081-.216z"/>
        </g>
      </svg>
    </div>
    <div class="bot-text">
      <span class="typing"></span>
      <span class="typing"></span>
      <span class="typing"></span>
    </div>
  `;
  chatBox.appendChild(div);
  chatBox.scrollTop = chatBox.scrollHeight;
}

/* Hapus typing */
function removeTyping() {
  const t = document.getElementById("typing");
  if (t) t.remove();
}


