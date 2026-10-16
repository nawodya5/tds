<link rel="stylesheet" href="{{ asset('css/profilecss.css') }}">

<section class="profile-section">
    <header class="profile-section-header profile-delete-warning">
        <h2 class="profile-section-title">{{ __('Delete Account') }}</h2>
        <p class="profile-section-description">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>

    <button type="button" class="profile-danger-button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="profile-section profile-modal-card">
            @csrf
            @method('delete')

            <h2 class="profile-modal-title">{{ __('Are you sure you want to delete your account?') }}</h2>
            <p class="profile-modal-description">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

            <div class="profile-field mt-6">
                <x-input-label for="password" :value="__('Password')" class="profile-label" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="{{ __('Enter your password') }}" autocomplete="current-password" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="profile-error" />
            </div>

            <div class="profile-modal-actions">
                <x-secondary-button x-on:click="$dispatch('close')" class="profile-cancel-button">{{ __('Cancel') }}</x-secondary-button>
                <button type="submit" class="profile-danger-button">{{ __('Delete Account Permanently') }}</button>
            </div>
        </form>
    </x-modal>
</section>