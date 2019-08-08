@component('mail::message')
# You have  Subscribed to our newsletter

with email adrress

{{ $email }}


Welcome on board!

@component('mail::button', ['url' => '#'])
View my Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
