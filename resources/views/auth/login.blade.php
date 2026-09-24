<x-layouts.auth title="Staff sign in">
    <p class="text-sm text-[#6E635C] dark:text-white/75">Sign in with your Gentriiq staff account.</p>
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5" x-data="{ submitting: false }" @submit="submitting = true">
        @csrf
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" autofocus
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="email-error" @enderror
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
            @error('email') <p id="email-error" role="alert" class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" @error('password') aria-describedby="password-error" @enderror
                class="w-full rounded-sm border border-black/20 bg-transparent px-3 py-2.5 focus:outline-2 focus:outline-[#D96B27] dark:border-white/30">
            @error('password') <p id="password-error" role="alert" class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p> @enderror
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input name="remember" type="checkbox" value="1" @checked(old('remember')) class="size-4 accent-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27]">
            Remember me
        </label>
        <button type="submit" :disabled="submitting" :aria-busy="submitting" class="w-full rounded-sm bg-[#D96B27] px-4 py-3 font-semibold text-white hover:bg-[#BF5A1B] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27] disabled:cursor-wait disabled:opacity-70">
            <span x-show="!submitting">Sign in</span>
            <span x-cloak x-show="submitting" role="status">Signing in…</span>
        </button>
    </form>

    <p class="text-center text-sm text-[#6E635C] dark:text-white/60">
        <a href="{{ route('password.request') }}" class="underline underline-offset-4 hover:text-[#D96B27]">Forgot your password?</a>
    </p>
</x-layouts.auth>
