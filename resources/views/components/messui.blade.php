<div id="messui-btn" onclick="toggleMessUI()">
    💬 Messages
</div>

<div id="messui-panel" style="display:none;">
    <div>
        Messages
        <span onclick="toggleMessUI()">✖</span>
    </div>

    <div id="chatBody"></div>

     <input id="messageInput" type="text">
    <button onclick="sendMessage()">Send</button>
</div>

<style>
/* BUTTON */
#messui-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #dd0d22;
    color: white;
    padding: 14px 18px;
    border-radius: 50px;
    cursor: pointer;
    font-weight: bold;
    z-index: 99999;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

/* PANEL */
#messui-panel {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    display: none;
    z-index: 99999;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

/* HEADER */
.messui-header {
    background: #dd0d22;
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    font-weight: bold;
}

/* IFRAME */
#messui-panel iframe {
    width: 100%;
    height: calc(100% - 40px);
    border: none;
}
</style>

<script>
function toggleMessUI() {
    const panel = document.getElementById('messui-panel');
    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
}
</script>

<script>
let receiverId = null;

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.chat-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            openChat(this.dataset.id);
        });
    });

});

function openChat(id) {
    console.log("Opening chat with seller:", id); // 🔥 debug

    receiverId = id;

    const panel = document.getElementById('messui-panel');
    if (!panel) {
        console.error("messui-panel not found");
        return;
    }

    panel.style.display = 'block';

    loadMessages();
}

function loadMessages() {
    if (!receiverId) return;

    fetch('/messages/' + receiverId + '/fetch')
        .then(res => res.text())
        .then(html => {
            document.getElementById('chatBody').innerHTML = html;
        });
}

function closeChat() {
    document.getElementById('messui-panel').style.display = 'none';
}
</script>
