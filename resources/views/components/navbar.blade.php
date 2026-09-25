<header x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    class="sticky top-0 z-40 w-full transition-shadow duration-300"
    :class="scrolled ? 'shadow-md' : 'border-b border-[#24140E]/10 dark:border-white/10'">

    <!-- Top Utility Bar (Hidden on Mobile) -->
    <div
        class="hidden border-b border-[#24140E]/10 bg-[#FAF6F0] text-xs text-[#6E635C] sm:block dark:border-white/10 dark:bg-[#180D08] dark:text-[#FAF6F0]/70">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 font-medium text-[#24140E] dark:text-[#FAF6F0]">
                    <span class="inline-block size-2 rounded-full bg-[#D96B27]"></span>
                    East Africa Safari Specialists
                </span>
                <span class="text-black/20 dark:text-white/20">|</span>
                <span class="hidden md:inline">Kenya &bull; Tanzania &bull; Uganda &bull; Rwanda</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <a href="tel:+254717838061"
                        class="font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0]">
                        +254 717 838061 <span class="text-[10px] text-[#D96B27]"></span>
                    </a>
                    <span class="text-black/20 dark:text-white/20">/</span>
                    <a href="tel:+254720115305"
                        class="transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                        +254 720 115305
                    </a>
                </div>
                <a href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris,%20I%20would%20like%20to%20plan%20a%20safari."
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 font-medium text-[#D96B27] hover:underline focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                    <svg class="size-3.5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.761.815 2.791.815 3.179 0 5.768-2.587 5.769-5.767.001-3.18-2.586-5.767-5.768-5.767zm9.969 5.765c0 5.518-4.482 10-10 10-1.748 0-3.385-.45-4.819-1.242l-5.181 1.357 1.383-5.053c-.886-1.488-1.383-3.228-1.383-5.062 0-5.518 4.482-10 10-10 5.518 0 10 4.482 10 10z" />
                    </svg>
                    WhatsApp Bookings
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="bg-white/95 backdrop-blur-md dark:bg-[#24140E]/95">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}"
                class="group flex items-center gap-3 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#D96B27]"
                aria-label="Gentriiq Safaris & Tours Home">
                <img src="{{ asset('assets/logo-light.png') }}" alt="Gentriiq Safaris & Tours" width="1259"
                    height="821" class="h-10 w-auto object-contain dark:hidden sm:h-12">
                <img src="{{ asset('assets/logo-dark.png') }}" alt="Gentriiq Safaris & Tours" width="1259"
                    height="821" class="hidden h-10 w-auto object-contain dark:block sm:h-12">
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden items-center gap-8 lg:flex" aria-label="Main Navigation">
                <a href="{{ route('home') }}#safaris"
                    class="text-sm font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]">
                    Safaris
                </a>
                <a href="{{ route('home') }}#destinations"
                    class="text-sm font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]">
                    Destinations
                </a>
                <a href="{{ route('home') }}#experiences"
                    class="text-sm font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]">
                    Experiences
                </a>
                <a href="{{ route('home') }}#why-gentriiq"
                    class="text-sm font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]">
                    Why Gentriiq
                </a>
                <a href="{{ route('about') }}"
                    class="text-sm font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]">
                    About
                </a>
                <a href="{{ route('home') }}#contact"
                    class="text-sm font-medium text-[#211915] transition-colors hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:text-[#D96B27]">
                    Contact
                </a>
            </nav>

            <!-- Actions Cluster -->
            <div class="hidden items-center gap-3 sm:flex">
                <a href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris,%20I%20would%20like%20to%20plan%20a%20custom%20safari"
                    target="_blank" rel="noopener noreferrer"
                    class="hidden items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-[#D96B27] hover:text-[#BF5A1B] focus-visible:outline-2 focus-visible:outline-[#D96B27] xl:inline-flex">
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.761.815 2.791.815 3.179 0 5.768-2.587 5.769-5.767.001-3.18-2.586-5.767-5.768-5.767zm9.969 5.765c0 5.518-4.482 10-10 10-1.748 0-3.385-.45-4.819-1.242l-5.181 1.357 1.383-5.053c-.886-1.488-1.383-3.228-1.383-5.062 0-5.518 4.482-10 10-10 5.518 0 10 4.482 10 10z" />
                    </svg>
                    WhatsApp
                </a>

                <x-button href="{{ route('plan.create') }}" variant="primary" size="md">
                    <span>Plan My Safari</span>
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </x-button>

                <!-- Theme Toggle Button -->
                <x-theme-toggle />
            </div>

            <!-- Mobile Cluster (Theme Toggle + Hamburger) -->
            <div class="flex items-center gap-2 lg:hidden">
                <x-theme-toggle />

                <!-- Mobile Hamburger Button -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center rounded-sm p-2 text-[#211915] hover:bg-[#FAF6F0] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0] dark:hover:bg-white/10"
                    :aria-expanded="mobileMenuOpen" aria-controls="mobile-navigation"
                    aria-label="Toggle navigation menu">
                    <svg x-show="!mobileMenuOpen" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-cloak x-show="mobileMenuOpen" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div x-cloak x-show="mobileMenuOpen" @keydown.window.escape="mobileMenuOpen = false" id="mobile-navigation"
        class="fixed inset-0 top-[60px] z-50 overflow-y-auto bg-black/50 backdrop-blur-xs lg:hidden sm:top-[90px]">
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" @click.away="mobileMenuOpen = false"
            class="min-h-full border-b border-[#24140E]/10 bg-[#FAF6F0] p-6 shadow-xl dark:border-white/10 dark:bg-[#180D08]">
            <nav class="space-y-4" aria-label="Mobile Navigation">
                <a href="{{ route('home') }}#safaris" @click="mobileMenuOpen = false"
                    class="block rounded-sm px-3 py-2.5 text-base font-semibold text-[#211915] transition-colors hover:bg-[#D96B27]/10 hover:text-[#D96B27] dark:text-[#FAF6F0]">
                    Safaris
                </a>
                <a href="{{ route('home') }}#destinations" @click="mobileMenuOpen = false"
                    class="block rounded-sm px-3 py-2.5 text-base font-semibold text-[#211915] transition-colors hover:bg-[#D96B27]/10 hover:text-[#D96B27] dark:text-[#FAF6F0]">
                    Destinations
                </a>
                <a href="{{ route('home') }}#experiences" @click="mobileMenuOpen = false"
                    class="block rounded-sm px-3 py-2.5 text-base font-semibold text-[#211915] transition-colors hover:bg-[#D96B27]/10 hover:text-[#D96B27] dark:text-[#FAF6F0]">
                    Experiences
                </a>
                <a href="{{ route('home') }}#why-gentriiq" @click="mobileMenuOpen = false"
                    class="block rounded-sm px-3 py-2.5 text-base font-semibold text-[#211915] transition-colors hover:bg-[#D96B27]/10 hover:text-[#D96B27] dark:text-[#FAF6F0]">
                    Why Gentriiq
                </a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                    class="block rounded-sm px-3 py-2.5 text-base font-semibold text-[#211915] transition-colors hover:bg-[#D96B27]/10 hover:text-[#D96B27] dark:text-[#FAF6F0]">
                    About Us
                </a>
                <a href="{{ route('home') }}#contact" @click="mobileMenuOpen = false"
                    class="block rounded-sm px-3 py-2.5 text-base font-semibold text-[#211915] transition-colors hover:bg-[#D96B27]/10 hover:text-[#D96B27] dark:text-[#FAF6F0]">
                    Contact
                </a>
            </nav>

            <div class="mt-8 space-y-4 border-t border-[#24140E]/10 pt-6 dark:border-white/10">
                <x-button href="{{ route('plan.create') }}" variant="primary" size="lg"
                    class="w-full justify-center">
                    Plan My Safari
                </x-button>

                <div class="grid grid-cols-2 gap-3">
                    <a href="tel:+254717838061"
                        class="flex items-center justify-center gap-1.5 rounded-sm border border-[#24140E]/20 bg-white py-2.5 text-xs font-semibold text-[#211915] transition-colors hover:bg-[#FAF6F0] dark:border-white/20 dark:bg-white/5 dark:text-[#FAF6F0]">
                        <svg class="size-3.5 text-[#D96B27]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Call Bookings
                    </a>
                    <a href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris" target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-center gap-1.5 rounded-sm bg-[#25D366]/15 py-2.5 text-xs font-semibold text-[#128C7E] transition-colors hover:bg-[#25D366]/25 dark:text-[#25D366]">
                        <svg class="size-3.5 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.761.815 2.791.815 3.179 0 5.768-2.587 5.769-5.767.001-3.18-2.586-5.767-5.768-5.767zm9.969 5.765c0 5.518-4.482 10-10 10-1.748 0-3.385-.45-4.819-1.242l-5.181 1.357 1.383-5.053c-.886-1.488-1.383-3.228-1.383-5.062 0-5.518 4.482-10 10-10 5.518 0 10 4.482 10 10z" />
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
