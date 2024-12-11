@component('mail::message')
# Welcome to our Golden Gate Colleges!

Your account has been created successfully.

Your login credentials are:
- Name: {{ $user->name }}
- Email: {{ $user->email }}
- Password: {{ $plainPassword }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent