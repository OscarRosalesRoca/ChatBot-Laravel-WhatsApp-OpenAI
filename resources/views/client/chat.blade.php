<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Chat</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .chat-box { border: 1px solid #ccc; padding: 10px; max-height: 400px; overflow-y: auto; margin-bottom: 10px; }
        .message { margin-bottom: 5px; }
        .admin { text-align: right; color: white; background-color: blue; padding: 5px; border-radius: 5px; display: inline-block; }
        .client { text-align: left; background-color: #eee; padding: 5px; border-radius: 5px; display: inline-block; }
    </style>
</head>
<body>

<h2>Chat</h2>

<!-- Set Name -->
@if(session('chat_name') === 'guest')
<form id="set-name-form" class="mb-4">
    <input type="text" id="client-name" placeholder="Your name" required>
    <button type="button" onclick="setName()">Set Name</button>
</form>
@endif

<!-- Chat Messages -->
<div class="chat-box" id="chat-box">
    @foreach($messages->reverse() as $msg)
        <div class="message {{ $msg->sender === 'admin' ? 'admin' : 'client' }}">
            <strong>{{ ucfirst($msg->sender) }}:</strong> {{ $msg->message }} <span style="font-size: 0.8em;">({{ $msg->created_at->format('H:i') }})</span>
        </div>
    @endforeach
</div>

<!-- Send Message -->
<form id="chat-form" class="mt-4" onsubmit="sendMessage(event)">
    <input type="text" id="message" placeholder="Write a message..." required>
    <button type="submit">Send</button>
</form>

<script>
function setName() {
    const name = document.getElementById('client-name').value;
    axios.post('{{ route("client.chat.set-name") }}', { name })
        .then(() => location.reload());
}

function sendMessage(e) {
    e.preventDefault();
    const msgInput = document.getElementById('message');
    if (!msgInput.value.trim()) return;

    axios.post('{{ route("client.chat.send") }}', { message: msgInput.value })
        .then(res => {
            const chatBox = document.getElementById('chat-box');
            const div = document.createElement('div');
            div.className = 'message client';
            div.innerHTML = `<strong>${res.data.sender}:</strong> ${res.data.message} <span style="font-size: 0.8em;">(${res.data.created_at})</span>`;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
            msgInput.value = '';
        });
}

// Auto-refresh every 2 seconds
setInterval(() => {
    axios.get('{{ route("client.chat") }}')
        .then(res => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';
            const parser = new DOMParser();
            const doc = parser.parseFromString(res.data, 'text/html');
            const messages = doc.querySelectorAll('.message');
            messages.forEach(m => chatBox.appendChild(m));
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}, 2000);
</script>

</body>
</html>
