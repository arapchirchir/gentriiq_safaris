<x-layouts.public title="Safari Plan"
    description="View your personalized East Africa safari plan. Send your inquiry directly via WhatsApp or share this link with travel companions.">

    <div clasclass="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Flash notification if newly generated --}}
            @if (session('success'))
                <div
                    class="mb-8 rounded-sm border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-900 dark:text-emerald-200">
                    <div class="flex items-center gap-3">
                        <svg class="size-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Top summary card --}}
            <div
                class="rounded-sm border border-black/10 bg-white p-6 shadow-sm sm:p-10 dark:border-white/10 dark:bg-[#24140E]">

                {{-- Header with Reference & Status --}}
                <div
                    class="flex flex-wrap items-center justify-between gap-4 border-b border-black/10 pb-6 dark:border-white/10">
                    <div>
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-[#D96B27]/10 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-[#D96B27]">
                            <span>Safari Plan Summary</span>
                        </div>
                        <h1 class="mt-2 text-2xl font-black text-[#211915] sm:text-3xl dark:text-white">
                            {{ $inquiry->name }}'s Safari Plan
                        </h1>
                        <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                            Created on {{ $inquiry->created_at->format('M d, Y \a\t H:i') }} (EAT)
                        </p>
                    </div>

                    <div class="text-right">
                        <span
                            class="block text-xs uppercase tracking-widest text-[#6E635C] dark:text-[#FAF6F0]/60">Booking
                            Reference</span>
                        <span
                            class="font-mono text-xl font-black tracking-wider text-[#D96B27]">{{ $inquiry->reference }}</span>
                        <div class="mt-1">
                            <span
                                class="inline-flex items-center rounded-sm bg-amber-500/10 px-2 py-0.5 text-[11px] font-semibold text-amber-700 dark:text-amber-400">
                                {{ ucfirst(str_replace('_', ' ', $inquiry->status ?? 'new')) }} - Ready to Send
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Key Safari Specifications Grid --}}
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    {{-- Trip Type --}}
                    <div
                        class="rounded-sm border border-black/5 bg-[#FAF6F0]/70 p-4 dark:border-white/5 dark:bg-[#180D08]/60">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Trip
                            Type</span>
                        <div class="mt-1 flex items-center gap-2">
                            <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                            </svg>
                            <span
                                class="text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->trip_type_label }}</span>
                        </div>
                    </div>

                    {{-- Travelers --}}
                    <div
                        class="rounded-sm border border-black/5 bg-[#FAF6F0]/70 p-4 dark:border-white/5 dark:bg-[#180D08]/60">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Travelers</span>
                        <div class="mt-1 flex items-center gap-2">
                            <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span
                                class="text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->traveller_label }}</span>
                        </div>
                    </div>

                    {{-- Travel Window --}}
                    <div
                        class="rounded-sm border border-black/5 bg-[#FAF6F0]/70 p-4 dark:border-white/5 dark:bg-[#180D08]/60">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Travel
                            Window</span>
                        <div class="mt-1 flex items-center gap-2">
                            <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-bold text-[#211915] dark:text-white">
                                {{ $inquiry->travel_date?->format('M d, Y') ?? $inquiry->travel_month . ' ' . $inquiry->travel_year }}
                                @if ($inquiry->travel_season)
                                    <span
                                        class="block text-[11px] font-normal text-[#D96B27]">{{ $inquiry->travel_season }}</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- Duration --}}
                    <div
                        class="rounded-sm border border-black/5 bg-[#FAF6F0]/70 p-4 dark:border-white/5 dark:bg-[#180D08]/60">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Planned
                            Duration</span>
                        <div class="mt-1 flex items-center gap-2">
                            <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span
                                class="text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->duration_label }}</span>
                        </div>
                    </div>

                    {{-- Accommodation --}}
                    <div
                        class="rounded-sm border border-black/5 bg-[#FAF6F0]/70 p-4 sm:col-span-2 dark:border-white/5 dark:bg-[#180D08]/60">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Accommodation
                            Preference</span>
                        <div class="mt-1 flex items-center gap-2">
                            <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span
                                class="text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->accommodation_label }}</span>
                        </div>
                    </div>
                </div>

                {{-- Contact Information & Guest Wishlist --}}
                <div class="mt-8 border-t border-black/10 pt-6 dark:border-white/10">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Guest Information & Wishlist
                    </h2>

                    <div class="mt-4 grid grid-cols-1 gap-4 text-xs sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <span class="text-[#6E635C] dark:text-[#FAF6F0]/60">Primary Guest</span>
                            <p class="mt-0.5 font-bold text-[#211915] dark:text-white">{{ $inquiry->name }}</p>
                        </div>
                        <div>
                            <span class="text-[#6E635C] dark:text-[#FAF6F0]/60">Email</span>
                            <p class="mt-0.5 font-bold text-[#211915] dark:text-white">{{ $inquiry->email }}</p>
                        </div>
                        <div>
                            <span class="text-[#6E635C] dark:text-[#FAF6F0]/60">Phone / WhatsApp</span>
                            <p class="mt-0.5 font-bold text-[#211915] dark:text-white">
                                {{ $inquiry->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <span class="text-[#6E635C] dark:text-[#FAF6F0]/60">Country</span>
                            <p class="mt-0.5 font-bold text-[#211915] dark:text-white">
                                {{ $inquiry->country ?? 'International' }}</p>
                        </div>
                    </div>

                    @if ($inquiry->special_requests)
                        <div
                            class="mt-4 rounded-sm border border-black/10 bg-[#FAF6F0] p-4 text-xs dark:border-white/10 dark:bg-[#180D08]">
                            <span class="font-bold text-[#D96B27]">Safari Wishlist & Special Notes:</span>
                            <p class="mt-1 leading-relaxed text-[#211915] dark:text-[#FAF6F0]">
                                {{ $inquiry->special_requests }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Action / WhatsApp / Link Sharing Section --}}
                <div
                    class="mt-10 rounded-sm border-2 border-[#D96B27] bg-[#FAF6F0] p-6 text-center sm:p-8 dark:bg-[#180D08]">
                    <div
                        class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#25D366]/10 text-[#25D366]">
                        <svg class="size-7" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                    </div>

                    <h3 class="mt-3 text-xl font-black text-[#211915] sm:text-2xl dark:text-white">
                        Send Your Safari Plan to Gentriiq Experts
                    </h3>
                    <p class="mx-auto mt-2 max-w-lg text-xs leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Clicking the button below opens WhatsApp directly with your reference number <strong
                            class="text-[#D96B27]">{{ $inquiry->reference }}</strong>, travel specifications, and this
                        unique link ready for our primary booking specialist (+254 717 838061).
                    </p>

                    {{-- WhatsApp Primary Action Button --}}
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ $inquiry->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-3 rounded-sm bg-[#25D366] px-8 py-3.5 text-sm font-bold text-white shadow-lg transition-transform hover:scale-[1.02] hover:bg-[#20ba5a]">
                            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            <span>Send Plan via WhatsApp</span>
                        </a>

                        <a href="tel:+254717838061"
                            class="inline-flex items-center gap-2 rounded-sm border border-black/20 bg-white px-5 py-3.5 text-sm font-semibold text-[#211915] transition-colors hover:bg-black/5 dark:border-white/20 dark:bg-transparent dark:text-white dark:hover:bg-white/10">
                            <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>Call +254 717 838061</span>
                        </a>
                    </div>

                    {{-- Unique Shareable Link Box --}}
                    <div class="mt-8 border-t border-black/10 pt-6 text-left dark:border-white/10"
                        x-data="{ copied: false, shareUrl: '{{ $inquiry->share_url }}' }">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                            Your Unique Plan Link (Saved in Database)
                        </label>
                        <p class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">
                            Anyone opening this permanent link will see your exact saved safari itinerary specs.
                        </p>

                        <div class="mt-2 flex items-center gap-2">
                            <input type="text" readonly :value="shareUrl"
                                class="w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 font-mono text-xs text-[#211915] select-all focus:outline-hidden dark:border-white/20 dark:bg-[#24140E] dark:text-white">

                            <button type="button"
                                @click="navigator.clipboard.writeText(shareUrl); copied = true; setTimeout(() => copied = false, 2500)"
                                class="inline-flex shrink-0 items-center gap-1.5 rounded-sm bg-[#D96B27] px-4 py-2.5 text-xs font-bold text-white transition-colors hover:bg-[#BF5A1B]">
                                <svg x-show="!copied" class="size-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <svg x-show="copied" class="size-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span x-text="copied ? 'Copied!' : 'Copy Link'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- What happens next guarantee --}}
                <div
                    class="mt-8 grid grid-cols-1 gap-4 border-t border-black/10 pt-6 sm:grid-cols-3 dark:border-white/10">
                    <div class="flex items-start gap-3">
                        <span
                            class="flex size-7 shrink-0 items-center justify-center rounded-full bg-[#D96B27]/10 font-bold text-[#D96B27]">1</span>
                        <div>
                            <h4 class="text-xs font-bold text-[#211915] dark:text-white">Expert Assignment</h4>
                            <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/70">A dedicated East African
                                safari specialist reviews your wishlist and dates.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="flex size-7 shrink-0 items-center justify-center rounded-full bg-[#D96B27]/10 font-bold text-[#D96B27]">2</span>
                        <div>
                            <h4 class="text-xs font-bold text-[#211915] dark:text-white">Custom Day-by-Day Itinerary
                            </h4>
                            <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/70">We map optimal park
                                routes, lodge availability, and 4x4 land cruisers.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span
                            class="flex size-7 shrink-0 items-center justify-center rounded-full bg-[#D96B27]/10 font-bold text-[#D96B27]">3</span>
                        <div>
                            <h4 class="text-xs font-bold text-[#211915] dark:text-white">Fast Response</h4>
                            <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/70">Receive your detailed PDF
                                safari plan and transparent pricing via WhatsApp and email within 2-4 hours.</p>
                        </div>
                    </div>
                </div>

                {{-- Footer Contacts & Link to Start Another Plan --}}
                <div
                    class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-black/10 pt-6 text-xs text-[#6E635C] dark:border-white/10 dark:text-[#FAF6F0]/70">
                    <div>
                        <span>Questions? Contact us: </span>
                        <a href="tel:+254717838061" class="font-bold text-[#D96B27] hover:underline">+254 717
                            838061</a>
                        <span> or </span>
                        <a href="tel:+254720115305" class="hover:underline">+254 720 115305</a>
                    </div>

                    <a href="{{ route('plan.create') }}" class="font-semibold text-[#D96B27] hover:underline">
                        &larr; Customize another safari plan
                    </a>
                </div>

            </div>

        </div>
    </div>

</x-layouts.public>
