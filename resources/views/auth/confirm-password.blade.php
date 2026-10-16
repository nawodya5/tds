<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/authcss.css') }}">
    @php
        $authSettings = \App\Models\Setting::query()->first();
        $authBrandName = $authSettings?->institute_name ?: 'TDS Attendance';
    @endphp
    <section class="auth-page">
        <div class="auth-brand">
            @if ($authSettings?->logo)
                <img src="{{ asset('storage/' . $authSettings->logo) }}" alt="{{ $authBrandName }} logo" class="auth-brand__logo">
            @else
                <span class="auth-brand__fallback" aria-hidden="true">
                    <svg width="23" height="23" viewBox="0 0 24 24" fill="none">
                        <path d="M4 18V6l8 7 8-7v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @endif
            <div>
                <p class="auth-brand__name">{{ $authBrandName }}</p>
                <p class="auth-brand__caption">Student attendance management</p>
            </div>
        </div>
        <header class="auth-heading">
            <span class="auth-eyebrow">Security check</span>
            <h1 class="auth-title">Confirm your password</h1>
            <p class="auth-description">This is a secure area. Please confirm your password before continuing.</p>
        </header>

        <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
            @csrf
            <div class="auth-field">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autofocus autocomplete="current-password" placeholder="Enter your current password" />
                <x-input-error :messages="$errors->get('password')" class="auth-error" />
            </div>

            <button type="submit" class="auth-submit auth-submit--full">
                <span>{{ __('Confirm and continue') }}</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
        <p class="auth-footer">Secure access · TDS Attendance System</p>
    </section>
</x-guest-layout>
