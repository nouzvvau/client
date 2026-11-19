@props(['form', 'class' => ''])

@php
    $url = \App\Support\GoogleForms::url($form);
    $isExternal = \App\Support\GoogleForms::isExternal($form);
@endphp

<a href="{{ $url }}"
   @if ($class !== '') class="{{ $class }}" @endif
   @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif
   {{ $attributes }}>
    {{ $slot }}
</a>
