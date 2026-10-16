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
            <span class="auth-eyebrow">Email verification</span>
            <h1 class="auth-title">Verify your email</h1>
            <p class="auth-description">One more step to secure your account.</p>
        </header>

        <div class="auth-notice">
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent you. If you did not receive the email, you can request another below.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="auth-status" role="status">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="auth-form">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="auth-submit auth-submit--full">
                    <span>{{ __('Resend verification email') }}</span>
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M20 7v5h-5M4 17v-5h5m-3-3a7 7 0 0 1 12-2l2 2M4 15l2 2a7 7 0 0 0 12-2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="auth-link" style="width:100%; padding:10px; background:transparent; border:0; box-shadow:none;">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
        <p class="auth-footer">Secure access · TDS Attendance System</p>
    </section>
</x-guest-layout>
