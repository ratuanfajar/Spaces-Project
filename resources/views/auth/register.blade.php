<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900">Create your account</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ password: '', password_confirm: '' }">
        @csrf

        <div class="mb-6">
            <x-input-label for="name" :value="__('Name')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="email" :value="__('E-mail Address')" class="text-lg font-bold text-gray-900 mb-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="text-lg font-bold text-gray-900 mb-1" />
            
            <x-password-input id="password" class="block w-full" name="password" required autocomplete="new-password" placeholder="Enter your password" x-model="password" />
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-10 relative">
            <x-input-label for="password_confirmation" :value="__('Password Again')" class="text-lg font-bold text-gray-900 mb-1" />
            
            <x-password-input id="password_confirmation" class="block w-full" name="password_confirmation" required autocomplete="new-password" placeholder="Enter your password again" x-model="password_confirm" />
            
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

            <div class="absolute top-full left-0 mt-1 w-full">
                
                <div x-show="password !== '' && password_confirm !== '' && password !== password_confirm" 
                     class="text-sm text-red-600 flex items-center transition-all duration-300"
                     x-transition.opacity>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    Passwords do not match.
                </div>

                <div x-show="password !== '' && password_confirm !== '' && password === password_confirm" 
                     class="text-sm text-green-600 flex items-center transition-all duration-300"
                     x-transition.opacity>
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                   </svg>
                   Passwords match.
               </div>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded font-semibold shadow-lg transition transform hover:scale-[1.01]">
                Sign Up
            </button>
        </div>
        
        <div class="mt-6 text-center">
             <span class="text-gray-500 text-sm">Already have an account?</span>
             <a href="{{ route('login') }}" class="text-slate-800 font-bold text-sm ml-1 hover:underline">Sign In</a>
        </div>
    </form>
</x-guest-layout>