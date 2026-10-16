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
            <span class="auth-eyebrow">Get started</span>
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-description">Set up your secure access to the attendance system.</p>
        </header>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            <div class="auth-register-grid">
                <div class="auth-field">
                <x-input-label for="name" :value="__('Full name')" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                <x-input-error :messages="$errors->get('name')" class="auth-error" />
            </div>

            <div class="auth-field">
                <x-input-label for="email" :value="__('Email address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="auth-error" />
            </div>

            <div class="auth-field">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                <x-input-error :messages="$errors->get('password')" class="auth-error" />
            </div>

            <div class="auth-field">
                <x-input-label for="password_confirmation" :value="__('Confirm password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Enter your password again" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
                </div>
            </div>

            <button type="submit" class="auth-submit auth-submit--full">
                <span>{{ __('Create account') }}</span>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="auth-divider"></div>
            <p class="auth-description" style="text-align:center; margin:0;">
                Already have an account?
                <a class="auth-link" href="{{ route('login') }}">Sign in</a>
            </p>
        </form>
        <p class="auth-footer">Secure access · TDS Attendance System</p>
    </section>
</x-guest-layout>
