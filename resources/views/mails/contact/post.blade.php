@component('mail::message')
# {{ __('Hello :name', ['name' => config('mail.to.name')]) }}

{{ __('You got message from :sender.', ['sender' => $request->name]) }}

@component('mail::panel')
{{ $request->message }}
@endcomponent

{{ __('Thank you') }},<br>
{{ config('app.name') }}
@endcomponent
