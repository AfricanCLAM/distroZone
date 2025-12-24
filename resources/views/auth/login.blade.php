<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NIK -->
        <div>
            <x-input-label for="NIK" :value="__('NIK')" />
            <x-text-input id="NIK" class="block mt-1 w-full" type="text" name="NIK" :value="old('NIK')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('NIK')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Show Password -->
        <div class="block mt-4">
            <label for="toggle_password" class="inline-flex items-center cursor-pointer">
                <input id="toggle_password" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    onclick="togglePassword()">
                <span class="ms-2 text-sm text-gray-600">
                    Show password
                </span>
            </label>
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
