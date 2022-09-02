@component('mail::message')
# Welcome to my channel

Thank you for visiting my channel. Have a great day.

@component('mail::button', ['url' => 'https://www.youtube.com'])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
