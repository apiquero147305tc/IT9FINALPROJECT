<div style="background:white; padding:15px;">
    @forelse($users as $chat)
        <a href="{{ route('messages.chat', $chat['user']->id) }}"
           style="display:block; padding:10px; border-bottom:1px solid #eee; text-decoration:none; color:black;">

            <b>{{ $chat['user']->name }}</b>
            <br>

            <small>
                {{ $chat['last_message']->message }}
            </small>

        </a>
    @empty
        <p>No conversations yet.</p>
    @endforelse
</div>

<x-messui />