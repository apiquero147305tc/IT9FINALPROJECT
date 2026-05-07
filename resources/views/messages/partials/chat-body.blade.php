@foreach($messages as $msg)
    <div style="margin:5px 0;">
        <b>{{ $msg->sender_id == auth()->id() ? 'You' : 'User' }}:</b>
        {{ $msg->message }}
    </div>
@endforeach