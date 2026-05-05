<!-- FLOATING CHAT BUTTON -->
<div id="messui-btn" onclick="toggleMessUI()">
    💬 Messages
</div>

<!-- FLOATING CHAT PANEL -->
<div id="messui-panel">
    <div class="messui-header">
        <span>Messages</span>
        <span onclick="toggleMessUI()" style="cursor:pointer;">✖</span>
    </div>

    <iframe src="{{ route('messages.inbox') }}"></iframe>
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
    let panel = document.getElementById('messui-panel');

    if (panel.style.display === "block") {
        panel.style.display = "none";
    } else {
        panel.style.display = "block";
    }
}
</script>