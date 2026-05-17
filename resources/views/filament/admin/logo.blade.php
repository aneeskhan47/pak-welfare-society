@php
    $name = filament()->getBrandName();
    $logoUrl = asset('images/pak-welfare-logo.png');
@endphp

<style>
    .fi-logo:has(.fi-pws-brand) {
        height: auto !important;
    }

    .fi-pws-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: nowrap;
        max-width: 100%;
    }

    .fi-pws-brand__img {
        display: block;
        height: 50px;
        width: 50px;
        flex-shrink: 0;
        object-fit: contain;
    }

    .fi-pws-brand__name {
        font-size: 0.875rem;
        font-weight: 700;
        line-height: 1.25;
        white-space: nowrap;
        color: rgb(3 7 18);
    }

    .dark .fi-pws-brand__name {
        color: rgb(255 255 255);
    }

    .fi-simple-header .fi-pws-brand {
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .fi-simple-header .fi-pws-brand__img {
        height: 200px;
        width: 200px;
    }

    .fi-simple-header .fi-pws-brand__name {
        text-align: center;
        white-space: normal;
    }
</style>

<div class="fi-pws-brand">
    <img
        src="{{ $logoUrl }}"
        alt="{{ $name }}"
        class="fi-pws-brand__img"
    />
    <span class="fi-pws-brand__name">{{ $name }}</span>
</div>
