@if(session('message'))
    <div class="message-box">
        {{session('message')}}
    </div>
@endif