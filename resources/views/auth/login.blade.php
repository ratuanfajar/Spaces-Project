<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
        <p class="text-gray-500 mt-2">Enter your details to sign in.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-8 relative">
            <x-input-label for="email" :value="__('E-mail Address')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            
            <div class="absolute top-full left-0 mt-1 w-full">
                <x-input-error :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="mb-8 relative">
            <x-input-label for="password" :value="__('Password')" class="text-lg font-bold text-gray-900 mb-1" />
            
            <x-password-input id="password" class="block w-full" name="password" required autocomplete="current-password" placeholder="Enter your password" />

            <div class="absolute top-full left-0 mt-1 w-full">
                <x-input-error :messages="$errors->get('password')" />
            </div>
        </div>

        <div class="flex items-center justify-between mb-8 mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-slate-700 shadow-sm focus:ring-slate-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-slate-600 hover:text-slate-900 underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded font-semibold shadow-lg transition">
                Sign In
            </button>
        </div>
        
        <div class="mt-6 text-center">
             <span class="text-gray-500 text-sm">Don't have an account?</span>
             <a href="{{ route('register') }}" class="text-slate-800 font-bold text-sm ml-1 hover:underline">Sign Up</a>
        </div>
    </form>
</x-guest-layout>