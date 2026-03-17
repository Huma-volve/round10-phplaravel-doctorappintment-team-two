@php
    $isRightAligned = false;
    $senderName = $message->sender->name ?? 'Unknown';
    if ($currentUser->role === 'admin') {
        $isRightAligned = ($message->sender->role ?? '') === 'doctor';
        $senderName = ($message->sender->role ?? '') === 'doctor' ? 'Dr. ' . $senderName : $senderName;
    } else {
        $isRightAligned = $message->sender_id === $currentUser->id;
        $senderName = $isRightAligned ? $currentUser->name : $senderName;
    }
@endphp
<div class="message-bubble-container {{ $isRightAligned ? 'justify-content-end' : 'justify-content-start' }}" id="message-container-{{ $message->id }}">
    <div class="message-bubble {{ $isRightAligned ? 'sent' : 'received' }}">
        @if($currentUser->role !== 'admin')
        <div class="message-dropdown dropdown">
            <i class="fa fa-chevron-down" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteMessage({{ $message->id }})"><i class="fa fa-trash me-2"></i> Delete</a></li>
            </ul>
        </div>
        @endif
        
        <div class="message-content">
            <span class="sender-name">{{ $senderName }}</span>@if($message->message_type == 'text')
                {{ $message->content }}
            @elseif($message->message_type == 'image')
                <div class="text-center mt-1">
                    <img src="{{ asset($message->content) }}" class="msg-image shadow-sm" onclick="window.open(this.src)">
                </div>
            @elseif($message->message_type == 'audio')
                <audio controls class="mt-1">
                    <source src="{{ asset($message->content) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            @endif
        </div>

        <div class="message-footer">
            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
            @if($message->sender_id === $currentUser->id)
                <i class="fa fa-check-double read-receipt {{ $message->is_read ? 'read' : '' }}"></i>
            @endif
        </div>
    </div>
</div>
