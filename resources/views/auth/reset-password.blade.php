<x-layouts.auth title="Set new password">
    <p class="text-sm text-[#6E635C] dark:text-white/75">Choose a strong password for your staff account.</p>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autocomplete="email"
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                @error('email') aria-describedby="email-error" @enderror
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
            @error('email')
                <p id="email-error" role="alert" class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium">New password</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                @error('password') aria-describedby="password-error" @enderror
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
            @error('password')
                <p id="password-error" role="alert" class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-medium">Confirm new password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
        </div>

        <button type="submit"
            class="w-full rounded-sm bg-[#D96B27] px-4 py-3 font-semibold text-white hover:bg-[#BF5A1B] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]">
            Reset password
        </button>
    </form>
</x-layouts.auth>
