<button type="button"
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        toggle() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.darkMode } }));
        }
    }"
    @theme-changed.window="darkMode = $event.detail.dark"
    @click="toggle()"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center size-9 rounded-sm border border-[#24140E]/15 bg-white/80 p-2 text-[#211915] transition-colors hover:bg-[#FAF6F0] hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:border-white/15 dark:bg-[#180D08]/80 dark:text-[#FAF6F0] dark:hover:bg-white/10 dark:hover:text-[#D96B27] cursor-pointer']) }}
    :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
    :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">

    <!-- Sun icon (shown when dark to switch to light) -->
    <svg x-show="darkMode" class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
    </svg>

    <!-- Moon icon (shown when light to switch to dark) -->
    <svg x-cloak x-show="!darkMode" class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
    </svg>
</button>
