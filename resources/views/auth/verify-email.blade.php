<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Verify Email</h2>
        <div class="text-sm text-gray-600 mt-4 leading-relaxed">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded font-semibold shadow-lg transition transform hover:scale-[1.01]">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-8 py-3 border border-gray-300 rounded text-gray-600 hover:bg-gray-50 transition text-sm">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>