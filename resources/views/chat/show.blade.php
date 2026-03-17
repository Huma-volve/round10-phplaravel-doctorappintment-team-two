@extends('chat.index')

@section('chat_content')
<style>
    .chat-header {
        padding: 12px 25px;
        background: #ffffff;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .header-user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-header h5 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .online-status {
        font-size: 0.75rem;
        color: var(--chat-primary-color);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .online-status::before {
        content: '';
        width: 8px;
        height: 8px;
        background: var(--chat-primary-color);
        border-radius: 50%;
    }

    .chat-messages {
        flex: 1;
        padding: 20px 30px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #efe7dd url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png') repeat;
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.1) transparent;
    }
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    .chat-messages::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    .chat-footer {
        padding: 12px 20px;
        background: #f0f2f5;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .chat-actions-left {
        display: flex;
        gap: 16px;
        color: #54656f;
        font-size: 1.3rem;
    }
    .chat-actions-left i {
        cursor: pointer;
        transition: color 0.2s;
    }
    .chat-actions-left i:hover {
        color: var(--chat-primary-color);
    }

    .chat-input-container {
        flex: 1;
        background: #ffffff;
        border-radius: 24px;
        padding: 4px 18px;
        display: flex;
        align-items: center;
        box-shadow: 0 1px 1px rgba(0,0,0,0.05);
    }
    .chat-input {
        border: none;
        background: transparent;
        width: 100%;
        padding: 8px 0;
        font-size: 0.95rem;
        outline: none;
        color: var(--text-main);
    }
    .send-circle {
        width: 45px;
        height: 45px;
        background: var(--chat-primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border: none;
        transition: transform 0.2s, background 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .send-circle:hover {
        transform: scale(1.05);
        background: #008f70;
    }
    .send-circle i {
        font-size: 1.2rem;
        margin-left: 2px;
    }

    /* Message Bubbles */
    .message-bubble-container {
        margin-bottom: 8px;
        width: 100%;
        display: flex;
    }
    /* Message Image styling */
    .msg-image {
        max-width: 250px;
        border-radius: 10px;
    }
    .message-bubble {
        width: fit-content;
        max-width: 60%;
        min-width: 80px;
        padding: 10px 14px 8px;
        border-radius: 12px;
        font-size: 0.95rem;
        position: relative;
        box-shadow: 0 1px 0.5px rgba(11,20,26,.13);
        line-height: 1.5;
        height: auto;
    }
    .message-bubble.received {
        align-self: flex-start;
        background: #ffffff;
        border-top-left-radius: 4px;
        color: var(--text-main);
    }
    .message-bubble.sent {
        align-self: flex-end;
        background: #dcf8c6;
        border-top-right-radius: 4px;
        color: #111b21;
    }
    .sender-name {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 2px;
        line-height: 1.2;
    }
    .message-bubble.sent .sender-name {
        color: #008069;
    }
    .message-bubble.received .sender-name {
        color: #e542a3; 
    }

    .message-content {
        word-wrap: break-word;
    }
    .message-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }
    .message-time {
        font-size: 0.68rem;
        color: rgba(102, 119, 129, 0.8);
    }
    .message-bubble.sent .message-time {
        color: rgba(17, 27, 33, 0.6);
    }
    .read-receipt {
        font-size: 0.75rem;
    }
    .read-receipt.read {
        color: #25d366;
    }

    .message-dropdown {
        position: absolute;
        top: 4px;
        right: 4px;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 5;
    }
    .message-bubble:hover .message-dropdown {
        opacity: 1;
    }
    .message-dropdown i {
        font-size: 0.75rem;
        color: var(--text-secondary);
        background: rgba(255,255,255,0.7);
        padding: 2px 5px;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

@if(auth()->user()->role !== 'admin')
<div class="doctor-session-bar px-4 py-1 bg-light border-bottom d-flex justify-content-between align-items-center">
    <small class="text-muted"><i class="fa fa-user-md me-1"></i> Logged in as: <strong>{{ $currentUser->role === 'admin' ? 'Admin' : 'Dr. ' . $currentUser->name }}</strong></small>
    <small class="badge bg-soft-primary text-primary">{{ $currentUser->doctor?->specialization?->name ?? 'System Admin' }}</small>
</div>
@endif
<div class="chat-header">
    <div class="header-user-info">
        <img src="{{ $other_user->profile_photo ? asset('storage/'.$other_user->profile_photo) : asset('assets/img/profiles/avatar-01.jpg') }}" alt="" class="chat-avatar">
        <div>
            <h5>{{ $other_user->name }}</h5>
            <div class="online-status">Online</div>
        </div>
    </div>
    <div class="chat-header-actions">
        <i class="fa fa-search text-muted me-3"></i>
        <i class="fa fa-ellipsis-v text-muted"></i>
    </div>
</div>

<div class="chat-messages" id="chatMessages">
    @foreach($chat->messages as $message)
        @include('chat.partials.message', ['message' => $message])
    @endforeach
</div>

@if(auth()->user()->role !== 'admin')
<div class="chat-footer">
    <div class="chat-actions-left">
        <label for="imgUpload" class="mb-0"><i class="fa fa-image"></i></label>
        <input type="file" id="imgUpload" class="d-none" accept="image/*" onchange="uploadFile('image')">
        
        <label for="audioUpload" class="mb-0"><i class="fa fa-microphone"></i></label>
        <input type="file" id="audioUpload" class="d-none" accept="audio/*" onchange="uploadFile('audio')">
    </div>
    
    <div class="chat-input-container">
        <input type="text" id="messageInput" class="chat-input" placeholder="Type a message..." onkeypress="handleKeyPress(event)">
    </div>
    
    <button class="send-circle" onclick="sendMessage()"><i class="fa fa-paper-plane"></i></button>
</div>
@else
<div class="chat-footer justify-content-center">
    <p class="text-muted mb-0"><i class="fa fa-info-circle me-1"></i> Admins can only view conversations.</p>
</div>
@endif

<script>
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const chatId = '{{ $chat->id }}';

    // Scroll to bottom
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    window.onload = scrollToBottom;

    function handleKeyPress(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    }

    async function sendMessage() {
        const content = messageInput.value.trim();
        if (!content) return;

        messageInput.value = '';
        
        try {
            const response = await fetch(`{{ route('chat.message.store', $chat->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    message_type: 'text',
                    content: content
                })
            });

            if (response.ok) {
                const html = await response.text();
                chatMessages.insertAdjacentHTML('beforeend', html);
                scrollToBottom();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function uploadFile(type) {
        const input = type === 'image' ? document.getElementById('imgUpload') : document.getElementById('audioUpload');
        if (!input.files.length) return;

        const formData = new FormData();
        formData.append('message_type', type);
        formData.append('content', input.files[0]);

        try {
            const response = await fetch(`{{ route('chat.message.store', $chat->id) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            if (response.ok) {
                const html = await response.text();
                chatMessages.insertAdjacentHTML('beforeend', html);
                scrollToBottom();
                input.value = ''; // Reset input
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function deleteMessage(messageId) {
        if (!confirm('Are you sure you want to delete this message?')) return;

        try {
            const response = await fetch(`/dashboard/message/${messageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const container = document.getElementById(`message-container-${messageId}`);
                if (container) {
                    container.style.opacity = '0';
                    setTimeout(() => container.remove(), 300);
                }
            } else {
                alert('Failed to delete message.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
@endsection
