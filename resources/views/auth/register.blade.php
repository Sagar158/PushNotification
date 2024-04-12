<x-guest-layout>
    <div class="auth-form-wrapper px-4 py-5">

        <a href="#" class="noble-ui-logo d-block mb-2">Noble<span>UI</span></a>
        <h5 class="text-muted font-weight-normal mb-4">Create a free account.</h5>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email"/>
            <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" placeholder="Password"/>
            <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password"/>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
