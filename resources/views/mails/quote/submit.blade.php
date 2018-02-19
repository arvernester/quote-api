@component('mail::message')
# {{ __('Hello') }}

{{ __('Someone has been submitted new quote. Please edit it to reject or approve new one.') }}

@component('mail::panel')
    {{ $quote->text }}

    {{ __('by') }} {{ $quote->author->name }}
@endcomponent

@component('mail::button', ['url' => route('admin.quote.edit', $quote)])
{{ __('Edit Quote') }}
@endcomponent

{{ __('Thank you') }},<br>
{{ config('app.name') }}
@endcomponent
