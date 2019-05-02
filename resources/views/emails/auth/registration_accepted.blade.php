@component('mail::message')
Olá {{$user->name}},
O teu registo no Agrupa foi aceite, clica no botão em baixo para te autenticares! 
@component('mail::button', ['url' => '/start','color' => 'success'])
Agrupa
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
