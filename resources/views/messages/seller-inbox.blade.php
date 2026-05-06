<h2>💬 Seller Messages</h2>

<a href="{{ route('seller.dash') }}">← Back to Dashboard</a>

<div style="margin-top:15px;">
@forelse($users as $chat)
    <a href="{{ route('messages.chat', $chat['user']->id) }}"
       style="display:block; padding:10px; border:1px solid #ddd; margin-bottom:10px; text-decoration:none; color:black;">

        <b>{{ $chat['user']->name }}</b><br>
        <small>{{ $chat['last_message']->message }}</small>

    </a>
@empty
    <p>No messages yet.</p>
@endforelse
</div>