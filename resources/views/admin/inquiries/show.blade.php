<x-layouts.admin :title="'Inquiry Dossier #' . $inquiry->reference">

    <div class="space-y-6">
        <!-- Top Action Bar -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.inquiries.index') }}"
                    class="inline-flex size-8 items-center justify-center rounded-sm border border-black/10 bg-white text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                    &larr;
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">
                            {{ $inquiry->name }}'s Safari Plan
                        </h2>
                        <span class="inline-flex items-center rounded-sm px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider
                            @if ($inquiry->status === 'new') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400
                            @elseif($inquiry->status === 'confirmed') bg-blue-500/10 text-blue-600 dark:text-blue-400
                            @elseif($inquiry->status === 'quote_sent') bg-amber-500/10 text-amber-600 dark:text-amber-400
                            @elseif($inquiry->status === 'cancelled') bg-rose-500/10 text-rose-600 dark:text-rose-400
                            @else bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 @endif">
                            {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                        </span>
                    </div>
                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Reference: <span class="font-mono font-bold text-[#D96B27]">{{ $inquiry->reference }}</span> &bull; Submitted {{ $inquiry->created_at->format('M d, Y \a\t H:i') }} (EAT)
                    </p>
                </div>
            </div>

            <!-- Quick Communication & Client Link Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('plan.show', ['token' => $inquiry->token]) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 rounded-sm border border-black/10 bg-white px-3 py-2 text-xs font-bold text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                    <svg class="size-4 text-[#D96B27]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>View Guest Proposal Page</span>
                </a>

                @if ($inquiry->phone)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $inquiry->phone);
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                        class="inline-flex items-center gap-1.5 rounded-sm bg-[#25D366] px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#20ba59]">
                        <span>WhatsApp Guest</span>
                    </a>

                    <a href="tel:{{ $inquiry->phone }}"
                        class="inline-flex items-center gap-1.5 rounded-sm border border-black/20 bg-white px-3 py-2 text-xs font-bold text-[#211915] hover:bg-black/5 dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <span>Call {{ $inquiry->phone }}</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Left 2 Columns: Safari Specifications & Guest Dossier -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Safari Specifications Card -->
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="border-b border-black/10 pb-3 text-xs font-bold uppercase tracking-wider text-[#D96B27] dark:border-white/10">
                        Tailored Safari Specifications
                    </h3>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 text-xs">
                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Trip Focus</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->trip_type_label }}</p>
                        </div>

                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Party Size</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->traveller_label }}</p>
                        </div>

                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Planned Duration</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->duration_label }}</p>
                        </div>

                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Travel Date Window</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">
                                {{ $inquiry->travel_date?->format('D, d M Y') ?? $inquiry->travel_month . ' ' . $inquiry->travel_year }}
                            </p>
                            @if ($inquiry->travel_season)
                                <p class="mt-0.5 text-[11px] text-[#D96B27]">{{ $inquiry->travel_season }}</p>
                            @endif
                        </div>

                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 sm:col-span-2 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Accommodation Style</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->accommodation_label }}</p>
                        </div>

                        @if ($inquiry->tour)
                            <div class="rounded-sm border border-[#D96B27]/30 bg-[#D96B27]/10 p-3.5 sm:col-span-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#D96B27]">Inquired From Package</span>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->tour->title }} ({{ $inquiry->tour->duration_days }} Days)</p>
                            </div>
                        @endif
                    </div>

                    <!-- Special Requests -->
                    @if ($inquiry->special_requests)
                        <div class="mt-5 rounded-sm border border-black/10 bg-[#FAF6F0] p-4 text-xs dark:border-white/10 dark:bg-[#180D08]">
                            <span class="font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Guest Wishlist & Special Requests:</span>
                            <p class="mt-2 whitespace-pre-line leading-relaxed text-[#211915] dark:text-white">
                                {{ $inquiry->special_requests }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Guest Profile Card -->
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="border-b border-black/10 pb-3 text-xs font-bold uppercase tracking-wider text-[#D96B27] dark:border-white/10">
                        Guest Contact Information
                    </h3>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 text-xs">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-[#6E635C] dark:text-[#FAF6F0]/60">Full Name</span>
                            <p class="mt-0.5 text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->name }}</p>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-bold text-[#6E635C] dark:text-[#FAF6F0]/60">Email Address</span>
                            <p class="mt-0.5 text-sm font-bold text-[#211915] dark:text-white">
                                <a href="mailto:{{ $inquiry->email }}" class="text-[#D96B27] hover:underline">{{ $inquiry->email }}</a>
                            </p>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-bold text-[#6E635C] dark:text-[#FAF6F0]/60">Phone / WhatsApp</span>
                            <p class="mt-0.5 text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->phone ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-bold text-[#6E635C] dark:text-[#FAF6F0]/60">Country of Residence</span>
                            <p class="mt-0.5 text-sm font-bold text-[#211915] dark:text-white">{{ $inquiry->country ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status Management & Staff Internal Notes -->
            <div class="space-y-6">
                <!-- Status & Operations Update Form -->
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="border-b border-black/10 pb-3 text-xs font-bold uppercase tracking-wider text-[#D96B27] dark:border-white/10">
                        Inquiry Status & Operations
                    </h3>

                    <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Current Status
                            </label>
                            <select id="status" name="status"
                                class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-xs font-semibold text-[#211915] outline-none focus:border-[#D96B27] focus:ring-1 focus:ring-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                                <option value="new" @selected($inquiry->status === 'new')>New (Pending Contact)</option>
                                <option value="contacted" @selected($inquiry->status === 'contacted')>Contacted (Discussion Active)</option>
                                <option value="quote_sent" @selected($inquiry->status === 'quote_sent')>Quote Sent (Proposal Shared)</option>
                                <option value="confirmed" @selected($inquiry->status === 'confirmed')>Confirmed (Deposit Paid)</option>
                                <option value="cancelled" @selected($inquiry->status === 'cancelled')>Cancelled / Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label for="internal_notes" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Internal Staff Notes
                            </label>
                            <textarea id="internal_notes" name="internal_notes" rows="6"
                                placeholder="Add internal notes about pricing discussions, safari vehicle allocation, lodge availability..."
                                class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-xs text-[#211915] outline-none focus:border-[#D96B27] focus:ring-1 focus:ring-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('internal_notes', $inquiry->internal_notes) }}</textarea>
                            <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                Visible only to Gentriiq staff and sales team.
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full rounded-sm bg-[#D96B27] py-2.5 text-xs font-bold text-white shadow-xs transition-colors hover:bg-[#BF5A1B]">
                            Save Status & Notes
                        </button>
                    </form>
                </div>

                <!-- Inquiry Metadata Card -->
                <div class="rounded-sm border border-black/10 bg-[#FAF6F0] p-4 text-[11px] dark:border-white/10 dark:bg-[#180D08]">
                    <span class="font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Audit Information</span>
                    <ul class="mt-2 space-y-1.5 text-[#6E635C] dark:text-[#FAF6F0]/70">
                        <li>Reference: <strong class="text-[#211915] dark:text-white">{{ $inquiry->reference }}</strong></li>
                        <li>Token: <span class="font-mono">{{ $inquiry->token }}</span></li>
                        <li>IP Address: {{ $inquiry->ip_address ?? 'N/A' }}</li>
                        <li>Last Updated: {{ $inquiry->updated_at->format('M d, Y H:i') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin>
