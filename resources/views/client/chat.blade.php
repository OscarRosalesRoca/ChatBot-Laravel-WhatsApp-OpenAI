<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Cliente</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Chat con Admin</h1>

    <div id="messages" style="border:1px solid #ccc; padding:10px; max-height:300px; overflow-y:auto;">
        @foreach ($messages as $message)
            <div><strong>{{ $message->sender }}:</strong> {{ $message->message }} <small>({{ $message->created_at->format('H:i') }})</small></div>
        @endforeach
    </div>

    <form id="chat-form">
        <input type="text" id="message" placeholder="Escribe tu mensaje..." required>
        <button type="submit">Enviar</button>
    </form>

    <script>
        const form = document.getElementById('chat-form');
        const messagesDiv = document.getElementById('messages');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const messageInput = document.getElementById('message');
            const message = messageInput.value.trim();
            if (!message) return;

            try {
                const response = await axios.post('{{ route('client.chat.send') }}', { message }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const msg = response.data;
                const div = document.createElement('div');
                div.innerHTML = `<strong>${msg.sender}:</strong> ${msg.message} <small>(${msg.created_at})</small>`;
                messagesDiv.appendChild(div);
                messagesDiv.scrollTop = messagesDiv.scrollHeight;

                messageInput.value = '';
            } catch (err) {
                console.error(err);
                alert('Error enviando mensaje');
            }
        });
    </script>
</body>
</html>
