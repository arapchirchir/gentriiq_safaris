<footer class="border-t border-[#24140E]/10 bg-[#180D08] text-[#FAF6F0] dark:border-white/10">
    <!-- Main Footer Content -->
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-5">

            <!-- Brand Column -->
            <div class="space-y-6 sm:col-span-2 lg:col-span-2">
                <a href="{{ route('home') }}"
                    class="inline-block focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                    <img src="{{ asset('assets/logo-dark.png') }}" alt="Gentriiq Safaris & Tours" width="1259"
                        height="821" class="h-12 w-auto object-contain">
                </a>
                <p class="max-w-md text-sm leading-relaxed text-[#FAF6F0]/75">
                    Gentriiq Safaris & Tours is a premier East African safari operator specializing in tailor-made
                    wildlife adventures, private luxury expeditions, and unforgettable journeys across Kenya, Tanzania,
                    Uganda, and Rwanda.
                </p>

                <!-- Direct Contact Badges -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center gap-3 text-sm text-[#FAF6F0]/90">
                        <span
                            class="flex size-8 shrink-0 items-center justify-center rounded-sm bg-[#D96B27]/20 text-[#D96B27]">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[#FAF6F0]/50">Call Safari Desk</p>
                            <div class="flex flex-wrap gap-x-2 font-medium">
                                <a href="tel:+254717838061" class="text-white hover:text-[#D96B27]">+254 717 838061
                                    <span class="text-xs text-[#D96B27]"></span></a>
                                <span class="text-white/20">&bull;</span>
                                <a href="tel:+254720115305" class="hover:text-[#D96B27]">+254 720 115305</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-sm text-[#FAF6F0]/90">
                        <span
                            class="flex size-8 shrink-0 items-center justify-center rounded-sm bg-[#25D366]/20 text-[#25D366]">
                            <svg class="size-4 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.761.815 2.791.815 3.179 0 5.768-2.587 5.769-5.767.001-3.18-2.586-5.767-5.768-5.767zm9.969 5.765c0 5.518-4.482 10-10 10-1.748 0-3.385-.45-4.819-1.242l-5.181 1.357 1.383-5.053c-.886-1.488-1.383-3.228-1.383-5.062 0-5.518 4.482-10 10-10 5.518 0 10 4.482 10 10z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[#FAF6F0]/50">Instant WhatsApp Bookings</p>
                            <a href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris,%20I%20would%20like%20to%20plan%20a%20safari."
                                target="_blank" rel="noopener noreferrer"
                                class="font-medium text-[#25D366] hover:underline">
                                Chat with an Expert (+254 717 838061)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column: Safari Packages -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-[#D96B27]">Featured Safaris</h3>
                <ul class="space-y-2.5 text-sm text-[#FAF6F0]/75">
                    <li><a href="#safaris" class="transition-colors hover:text-[#FAF6F0]">5-Day Maasai Mara & Nakuru</a>
                    </li>
                    <li><a href="#safaris" class="transition-colors hover:text-[#FAF6F0]">7-Day Kenya Classic Safari</a>
                    </li>
                    <li><a href="#safaris" class="transition-colors hover:text-[#FAF6F0]">4-Day Amboseli &
                            Kilimanjaro</a></li>
                    <li><a href="#safaris" class="transition-colors hover:text-[#FAF6F0]">10-Day Kenya & Tanzania</a>
                    </li>
                    <li><a href="#safaris" class="transition-colors hover:text-[#FAF6F0]">3-Day Samburu Wilderness</a>
                    </li>
                    <li><a href="#safaris" class="transition-colors hover:text-[#FAF6F0]">Private Custom Safaris</a>
                    </li>
                </ul>
            </div>

            <!-- Column: Destinations -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-[#D96B27]">Destinations</h3>
                <ul class="space-y-2.5 text-sm text-[#FAF6F0]/75">
                    <li><a href="#destinations" class="transition-colors hover:text-[#FAF6F0]">Maasai Mara Reserve</a>
                    </li>
                    <li><a href="#destinations" class="transition-colors hover:text-[#FAF6F0]">Amboseli National
                            Park</a></li>
                    <li><a href="#destinations" class="transition-colors hover:text-[#FAF6F0]">Serengeti &
                            Ngorongoro</a></li>
                    <li><a href="#destinations" class="transition-colors hover:text-[#FAF6F0]">Samburu & Buffalo
                            Springs</a></li>
                    <li><a href="#destinations" class="transition-colors hover:text-[#FAF6F0]">Lake Nakuru &
                            Naivasha</a></li>
                    <li><a href="#destinations" class="transition-colors hover:text-[#FAF6F0]">Diani Beach & Coast</a>
                    </li>
                </ul>
            </div>

            <!-- Column: Experiences & Quick Links -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-[#D96B27]">Experiences</h3>
                <ul class="space-y-2.5 text-sm text-[#FAF6F0]/75">
                    <li><a href="#experiences" class="transition-colors hover:text-[#FAF6F0]">The Big Five
                            Expeditions</a></li>
                    <li><a href="#experiences" class="transition-colors hover:text-[#FAF6F0]">Great Migration
                            Safaris</a></li>
                    <li><a href="#experiences" class="transition-colors hover:text-[#FAF6F0]">Luxury Honeymoon
                            Holidays</a></li>
                    <li><a href="#experiences" class="transition-colors hover:text-[#FAF6F0]">Family Friendly
                            Safaris</a></li>
                    <li><a href="#experiences" class="transition-colors hover:text-[#FAF6F0]">Birding & Photography</a>
                    </li>
                    <li><a href="#experiences" class="transition-colors hover:text-[#FAF6F0]">Bush to Beach Holidays</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Trust Badges & Booking CTA Strip -->
        <div class="mt-14 rounded-sm border border-white/10 bg-[#24140E] p-6 sm:p-8">
            <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
                <div class="text-center md:text-left">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#D96B27]">Ready for an Unforgettable
                        Journey?</p>
                    <h4 class="mt-1 text-xl font-semibold text-white">Let our local safari specialists tailor your dream
                        itinerary</h4>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <x-button href="{{ route('plan.create') }}" variant="primary" size="md">
                        Start Planning Your Trip
                    </x-button>
                    <a href="tel:+254717838061"
                        class="inline-flex items-center justify-center rounded-sm border border-white/20 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                        Call +254 717 838061
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div
            class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-xs text-[#FAF6F0]/50 sm:flex-row">
            <p>&copy; {{ date('Y') }} Gentriiq Safaris & Tours. All rights reserved. Kenya &bull; East Africa.</p>
            <div class="flex items-center gap-6">
                <a href="#top" class="hover:text-white">Back to top &uarr;</a>
                <span>&bull;</span>
                <a href="{{ route('dashboard') }}" class="hover:text-white">Staff Portal</a>
            </div>
        </div>
    </div>
</footer>
