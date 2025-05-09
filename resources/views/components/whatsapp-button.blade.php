@props(['whatsapp', 'message' => ''])

@php
    $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsapp);
    $encodedMessage = urlencode($message);
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
@endphp

<a href="{{ $whatsappUrl }}" target="_blank" {{ $attributes->merge(['class' => 'whatsapp-button']) }}>
    <i class="fab fa-whatsapp"></i> WhatsApp
</a>
