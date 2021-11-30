@component('mail::message')
Hello {{$user->name}},

Welcome to {{config('app.name')}}!

Please use the following password to login to the system.

Password : {{$password}}

@component('mail::button', ['url' => route('login')])
Click here to login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
