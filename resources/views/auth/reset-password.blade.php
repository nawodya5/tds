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
            <span class="auth-eyebrow">Account recovery</span>
            <h1 class="auth-title">Set a new password</h1>
            <p class="auth-description">Choose a strong password to secure your account.</p>
        </header>

        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="auth-field">
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="auth-error" />
            </div>

            <div class="auth-field">
                <x-input-label for="password" :value="__('New password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Enter a new password" />
                <x-input-error :messages="$errors->get('password')" class="auth-error" />
            </div>

            <div class="auth-field">
                <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Enter the password again" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
            </div>

            <button type="submit" class="auth-submit auth-submit--full">
                <span>{{ __('Reset password') }}</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
        <p class="auth-footer">Secure access · TDS Attendance System</p>
    </section>
</x-guest-layout>
