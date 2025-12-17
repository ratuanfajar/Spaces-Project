<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Forgot Password?</h2>
        <p class="text-gray-500 mt-2 text-sm leading-relaxed">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-10 relative">
            <x-input-label for="email" :value="__('E-mail Address')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter your registered email" />
            
            <div class="absolute top-full left-0 mt-1 w-full">
                <x-input-error :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded font-semibold shadow-lg transition transform hover:scale-[1.01]">
                Email Password Reset Link
            </button>
        </div>
        
        <div class="mt-6 text-center">
             <a href="{{ route('login') }}" class="text-gray-500 text-sm hover:text-slate-800 hover:underline">
                 &larr; Back to Login
             </a>
        </div>
    </form>
</x-guest-layout>