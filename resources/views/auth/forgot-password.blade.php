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
            <h1 class="auth-title">Forgot your password?</h1>
            <p class="auth-description">Enter the email address linked to your account. We'll send you a password reset link.</p>
        </header>

        <x-auth-session-status class="auth-status" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            <div class="auth-field">
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="auth-error" />
            </div>

            <button type="submit" class="auth-submit auth-submit--full">
                <span>{{ __('Send reset link') }}</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6h16v12H4zM4 7l8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <p class="auth-description" style="text-align:center; margin:0;">
                <a class="auth-link" href="{{ route('login') }}">Back to sign in</a>
            </p>
        </form>
        <p class="auth-footer">Secure access · TDS Attendance System</p>
    </section>
</x-guest-layout>
