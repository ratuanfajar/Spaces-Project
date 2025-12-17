<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
        <p class="text-gray-500 mt-2">Create a new secure password.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-8 relative">
            <x-input-label for="email" :value="__('E-mail Address')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <div class="absolute top-full left-0 mt-1 w-full">
                <x-input-error :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="mb-8 relative">
            <x-input-label for="password" :value="__('New Password')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-password-input id="password" class="block w-full" name="password" required autocomplete="new-password" placeholder="Enter new password" />
            <div class="absolute top-full left-0 mt-1 w-full">
                <x-input-error :messages="$errors->get('password')" />
            </div>
        </div>

        <div class="mb-10 relative">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-password-input id="password_confirmation" class="block w-full" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password" />
            <div class="absolute top-full left-0 mt-1 w-full">
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded font-semibold shadow-lg transition transform hover:scale-[1.01]">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>