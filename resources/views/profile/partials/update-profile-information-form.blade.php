<link rel="stylesheet" href="{{ asset('css/profilecss.css') }}">

<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">{{ __('Profile Information') }}</h2>
        <p class="profile-section-description">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="profile-field">
            <x-input-label for="name" :value="__('Name')" class="profile-label" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="profile-error" :messages="$errors->get('name')" />
        </div>

        <div class="profile-field">
            <x-input-label for="email" :value="__('Email')" class="profile-label" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="profile-error" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="profile-verification">
                {{ __('Your email address is unverified.') }}
                <button form="send-verification">{{ __('Click here to re-send the verification email.') }}</button>

                @if (session('status') === 'verification-link-sent')
                <p class="profile-status mt-2">{{ __('A new verification link has been sent to your email address.') }}</p>
                @endif
            </div>
            @endif
        </div>

        <div class="profile-actions">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="profile-status">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>