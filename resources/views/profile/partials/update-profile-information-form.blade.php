<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="image_file" :value="__('image_file')" />
            <x-fields.image name="image_file" label="Profile Image" width="md" deleteTitle="Delete Image"
                :deleteAllow="$user->imageExists" deleteForm="form_to_delete_image" :imageUrl="$user->imageUrl" readonly="$mode == 'edit'" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        @if ($user?->customer)
            <div>
                <x-input-label for="nif" :value="__('NIF')" />
                <x-text-input id="nif" name="nif" type="text" class="mt-1 block w-full" :value="old('nif', $user->customer?->nif)"
                    autofocus autocomplete="nif" />
                <x-input-error class="mt-2" :messages="$errors->get('nif')" />
            </div>
            <div>
                <x-input-label for="payType" :value="__('Payment Type')" />
                <x-fields.select name="payType" :options="[
                    null => 'Not set',
                    'PAYPAL' => 'PayPal',
                    'MBWAY' => 'MBWay',
                    'VISA' => 'Visa credit card',
                ]"
                    value="{{ old('payType', $user->customer?->payment_type) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('nif')" />
            </div>
            <div>
                <x-input-label for="payRef" :value="__('Payment Reference')" />
                <x-text-input id="payRef" name="payRef" type="text" class="mt-1 block w-full" :value="old('payRef', $user->customer?->payment_ref)"
                    autofocus autocomplete="payRef" />
                <x-input-error class="mt-2" :messages="$errors->get('payRef')" />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <form class="hidden" id="form_to_delete_photo" method="POST"
        action="{{ route('users.image.destroy', ['user' => $user]) }}">
        @csrf
        @method('DELETE')
    </form>
</section>
