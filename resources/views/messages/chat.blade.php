@if(auth()->user()->role === 'seller')
    <a href="{{ route('seller.dash') }}"
       style="display:inline-block; margin-bottom:10px; text-decoration:none; color:#dd0d22; font-weight:bold;">
        ← Back to Seller Dashboard
    </a>
@elseif(auth()->user()->role === 'buyer')
    <a href="{{ route('buyer.home') }}"
       style="display:inline-block; margin-bottom:10px; text-decoration:none; color:#dd0d22; font-weight:bold;">
        ← Back to Home
    </a>
@endif

<h2>Chat with {{ $receiver->name }}</h2>


<div class="chat-box" style="height:350px; overflow-y:auto;">
@foreach($messages as $msg)
    <div style="margin:5px 0;">
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

<script>
    const box = document.querySelector('.chat-box');
    if (box) box.scrollTop = box.scrollHeight;
</script>
