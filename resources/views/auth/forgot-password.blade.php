<x-layouts.auth title="Reset your password">
    <p class="text-sm text-[#6E635C] dark:text-white/75">
        Enter the email address of your staff account and we will send you a password reset link.
    </p>

    @if (session('status'))
        <div class="rounded-sm border border-emerald-500/20 bg-emerald-500/10 p-3 text-sm text-emerald-700 dark:text-emerald-300">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                @error('email') aria-describedby="email-error" @enderror
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
            @error('email')
                <p id="email-error" role="alert" class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full rounded-sm bg-[#D96B27] px-4 py-3 font-semibold text-white hover:bg-[#BF5A1B] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]">
            Send reset link
        </button>
    </form>

    <p class="text-center text-sm">
        <a href="{{ route('login') }}" class="underline underline-offset-4 hover:text-[#D96B27]">Back to sign in</a>
    </p>
</x-layouts.auth>
