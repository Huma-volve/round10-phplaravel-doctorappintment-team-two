@extends('layouts.dashboard')

@section('title', 'Chat')

@section('content')
<style>
    :root {
        --chat-sidebar-width: 380px;
        --chat-primary-color: #00a884;
        --chat-bg-soft: #f0f2f5;
        --chat-sidebar-bg: #ffffff;
        --chat-item-hover: #f5f6f6;
        --chat-item-active: #ebebeb;
        --text-main: #111b21;
        --text-secondary: #667781;
        --border-color: #e9edef;
    }

    .chat-container {
        display: flex;
        height: calc(100vh - 120px);
        background: var(--chat-sidebar-bg);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        border: 1px solid var(--border-color);
        margin-top: 20px;
    }

    .chat-sidebar {
        width: var(--chat-sidebar-width);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        background: var(--chat-sidebar-bg);
    }

    .chat-sidebar-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        background: #fdfdfd;
    }

    .doctor-profile-brief {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 12px;
    }

    .doctor-profile-brief img {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--chat-primary-color);
        padding: 2px;
    }

    .doctor-profile-brief .doc-info h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .doctor-profile-brief .doc-info p {
        margin: 0;
        font-size: 0.8rem;
        color: var(--chat-primary-color);
        font-weight: 500;
    }

    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .chat-list {
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #ced0d1 transparent;
    }

    .chat-list::-webkit-scrollbar {
        width: 6px;
    }
    .chat-list::-webkit-scrollbar-thumb {
        background-color: #ced0d1;
        border-radius: 10px;
    }

    .chat-item {
        padding: 12px 20px;
        border-bottom: 1px solid #f8f9fa;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        text-decoration: none !important;
        color: inherit;
    }

    .chat-item:hover {
        background: var(--chat-item-hover);
    }

    .chat-item.active {
        background: var(--chat-item-active);
    }

    .chat-avatar-wrapper {
        position: relative;
        margin-right: 15px;
    }

    .chat-avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        object-fit: cover;
    }

    .chat-status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #25d366;
        border: 2px solid #fff;
        border-radius: 50%;
    }

    .chat-info {
        flex: 1;
        min-width: 0;
    }

    .chat-name-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .chat-name {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-main);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-time {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .chat-msg-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-last-msg {
        font-size: 0.88rem;
        color: var(--text-secondary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }

    .unread-badge {
        background: var(--chat-primary-color);
        color: white;
        border-radius: 50%;
        min-width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
        margin-left: 8px;
    }

    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f0f2f5;
        position: relative;
    }

    .chat-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: #f8f9fa;
        color: var(--text-secondary);
        text-align: center;
        padding: 40px;
    }

    .chat-empty i {
        font-size: 5rem;
        color: #e9edef;
        margin-bottom: 24px;
    }

    .sidebar-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        margin-bottom: 5px;
    }
    .chat-tabs {
        display: flex;
        gap: 8px;
        padding-bottom: 5px;
    }
    .chat-tab {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        background: #f0f2f5;
        color: var(--text-secondary);
        border: none;
    }
    .chat-tab.active {
        background: var(--chat-primary-color);
        color: #fff;
    }
    .chat-tab:hover:not(.active) {
        background: #e9edef;
    }

    .chat-item-container {
        position: relative;
    }
    .favorite-toggle {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1rem;
        color: #d1d7db;
        transition: all 0.2s ease;
        z-index: 10;
        cursor: pointer;
    }
    .favorite-toggle:hover {
        transform: translateY(-50%) scale(1.2);
    }
    .favorite-toggle.is-favorite {
        color: #ffb800;
    }
    .favorite-badge {
        font-size: 0.65rem;
        background: rgba(255,184,0,0.1);
        color: #ffb800;
        padding: 1px 6px;
        border-radius: 4px;
        margin-left: 5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="chat-container">
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <div class="doctor-profile-brief">
                <img src="{{ $currentUser->profile_photo ? asset('storage/'.$currentUser->profile_photo) : asset('assets/img/profiles/avatar-02.jpg') }}" alt="">
                <div class="doc-info">
                    <h6>{{ $currentUser->name }}</h6>
                    <p>{{ $currentUser->doctor->specialization->name ?? 'Doctor' }}</p>
                </div>
            </div>
            <div class="sidebar-title-row">
                <h5 class="mb-0 sidebar-title">Messages</h5>
            </div>
            <div class="chat-tabs mt-2">
                <button class="chat-tab active" onclick="filterChats('all', this)">All</button>
                <button class="chat-tab" onclick="filterChats('starred', this)">Starred</button>
            </div>
        </div>
        <div class="chat-list" id="chatList">
            @forelse($chats as $c)
                <div class="chat-item-container" data-starred="{{ $c->is_favorite ? 'true' : 'false' }}">
                    <span class="favorite-toggle {{ $c->is_favorite ? 'is-favorite' : '' }}" onclick="toggleFavorite(event, '{{ $c->id }}')">
                        <i class="fa{{ $c->is_favorite ? 's' : 'r' }} fa-star"></i>
                    </span>
                    <a href="{{ route('chat.show', $c->id) }}" class="chat-item {{ isset($chat) && $chat->id == $c->id ? 'active' : '' }}">
                        <div class="chat-avatar-wrapper">
                            <img src="{{ $c->other_user->profile_photo ? asset('storage/'.$c->other_user->profile_photo) : asset('assets/img/profiles/avatar-01.jpg') }}" alt="" class="chat-avatar">
                            <div class="chat-status-indicator"></div>
                        </div>
                        <div class="chat-info">
                            <div class="chat-name-row">
                                <span class="chat-name">
                                    {{ $c->other_user->name ?? 'User' }}
                                    @if($c->is_favorite)
                                        <span class="favorite-badge">Starred</span>
                                    @endif
                                </span>
                                <span class="chat-time">{{ $c->last_message ? $c->last_message->created_at->diffForHumans(null, true) : '' }}</span>
                            </div>
                            <div class="chat-msg-row">
                                <div class="chat-last-msg">
                                    @if($c->last_message)
                                        @if($c->last_message->message_type == 'text')
                                            {{ $c->last_message->content }}
                                        @elseif($c->last_message->message_type == 'image')
                                            <i class="fa fa-camera me-1"></i> Photo
                                        @elseif($c->last_message->message_type == 'audio')
                                            <i class="fa fa-microphone me-1"></i> Audio
                                        @endif
                                    @else
                                        No messages yet
                                    @endif
                                </div>
                                @if($c->unread_count > 0)
                                    <span class="unread-badge">{{ $c->unread_count }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="p-4 text-center text-muted">No chats found.</div>
            @endforelse
        </div>
    </div>

    <div class="chat-main">
        @yield('chat_content')
        @if(!isset($chat))
            <div class="chat-empty">
                <i class="fa fa-comments"></i>
                <h3>Select a chat to start messaging</h3>
                <p>Communicate with your patients in real-time.</p>
            </div>
        @endif
        <script>
    function filterChats(filter, element) {
        // Toggle active tab class
        document.querySelectorAll('.chat-tab').forEach(tab => tab.classList.remove('active'));
        element.classList.add('active');

        // Filter items
        const items = document.querySelectorAll('.chat-item-container');
        items.forEach(item => {
            if (filter === 'all') {
                item.style.display = 'block';
            } else if (filter === 'starred') {
                const isStarred = item.getAttribute('data-starred') === 'true';
                item.style.display = isStarred ? 'block' : 'none';
            }
        });

        // Show empty message if nothing found
        const visibleItems = Array.from(items).filter(item => item.style.display !== 'none');
        const emptyMsg = document.getElementById('emptyListMessage');
        if (visibleItems.length === 0) {
            if (!emptyMsg) {
                const msg = document.createElement('div');
                msg.id = 'emptyListMessage';
                msg.className = 'p-4 text-center text-muted';
                msg.innerText = filter === 'starred' ? 'No starred chats yet.' : 'No chats found.';
                document.getElementById('chatList').appendChild(msg);
            } else {
                emptyMsg.innerText = filter === 'starred' ? 'No starred chats yet.' : 'No chats found.';
                emptyMsg.style.display = 'block';
            }
        } else if (emptyMsg) {
            emptyMsg.style.display = 'none';
        }
    }

    async function toggleFavorite(event, chatId) {
        event.preventDefault();
        event.stopPropagation();
        
        try {
            const response = await fetch(`/dashboard/chats/${chatId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                // Reload to apply new sorting (Favorite at top)
                window.location.reload();
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
        }
    }
</script>
@endsection
