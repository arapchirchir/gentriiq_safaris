<x-layouts.auth title="Confirm your password">
    <p class="text-sm text-[#6E635C] dark:text-white/75">Enter your password to continue.</p>
    <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
        @csrf
        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" autofocus
                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                @error('password') aria-describedby="password-error" @enderror
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
            @error('password')
                <p id="password-error" role="alert" class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="w-full rounded-sm bg-[#D96B27] px-4 py-3 font-semibold text-white hover:bg-[#BF5A1B] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]">Confirm password</button>
    </form>
</x-layouts.auth>
