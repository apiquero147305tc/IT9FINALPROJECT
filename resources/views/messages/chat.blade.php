<a href="{{ route('messages.inbox') }}"
   style="display:inline-block; margin-bottom:10px; text-decoration:none; color:#dd0d22; font-weight:bold;">
    ← Back to Messages
</a>

<h2>Chat with {{ $receiver->name }}</h2>


<div style="background:white; padding:15px; height:400px; overflow-y:auto;">
    @foreach($messages as $msg)
        <div style="margin-bottom:10px;">
            <b>{{ $msg->sender_id == auth()->id() ? 'You' : $receiver->name }}:</b>
            {{ $msg->message }}
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route('messages.send') }}">
    @csrf

    <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

    <input type="text" name="message" placeholder="Type message..." required>

    <button type="submit">Send</button>
</form>