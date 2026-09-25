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
                        Reference: <span class="font-mono font-bold text-[#D96B27]">{{ $inquiry->reference }}</span> &bull; Submitted {{ $inquiry->created_at->timezone('Africa/Nairobi')->format('M d, Y \a\t H:i') }} (EAT)
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
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Experiences</span>
                            <div class="mt-1.5 flex flex-wrap gap-1.5">
                                @forelse ($inquiry->experiences as $experience)
                                    <span class="rounded-xs bg-[#D96B27]/10 px-2 py-0.5 text-[11px] font-bold text-[#D96B27]">{{ $experience->name }}</span>
                                @empty
                                    <span class="font-bold text-[#211915] dark:text-white">Custom Safari</span>
                                @endforelse
                            </div>
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

                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Accommodation Style</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->accommodation_label }}</p>
                        </div>

                        <div class="rounded-sm border border-black/5 bg-[#FAF6F0] p-3.5 dark:border-white/5 dark:bg-[#180D08]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Budget per Person</span>
                            <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->budget_label ?? 'Not specified' }}</p>
                            @if ($inquiry->budget_label)
                                <p class="mt-0.5 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Excluding international flights</p>
                            @endif
                        </div>

                        @if ($inquiry->tour)
                            <div class="rounded-sm border border-[#D96B27]/30 bg-[#D96B27]/10 p-3.5 sm:col-span-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#D96B27]">Inquired From Package</span>
                                <p class="mt-1 font-bold text-[#211915] dark:text-white">{{ $inquiry->tour->title }} ({{ $inquiry->tour->duration_days }} Days)</p>
                                @php
                                    $travellers = $inquiry->adults_count + $inquiry->children_count;
                                @endphp
                                <p class="mt-1 text-[#211915] dark:text-white">
                                    From <span class="font-bold">{{ $inquiry->tour->formatted_price }}</span> per person
                                    &times; {{ $travellers }} {{ \Illuminate\Support\Str::plural('traveller', $travellers) }}
                                    &asymp; <span class="font-bold">{{ $inquiry->tour->formatMoney((float) $inquiry->tour->starting_price * $travellers) }}</span>
                                </p>
                                <p class="mt-0.5 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Rough guide at the starting price, before child rates, season and accommodation upgrades.</p>
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

                <!-- Quoting Guide: packages matching the guest's experiences -->
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex items-baseline justify-between border-b border-black/10 pb-3 dark:border-white/10">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Matching Packages</h3>
                        <span class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Starting points for the quote</span>
                    </div>
                    @if ($matchingTours->isEmpty())
                        <p class="mt-4 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                            No published packages are tagged with these experiences yet. Tag tours with experiences in
                            <a href="{{ route('admin.tours.index') }}" class="font-semibold text-[#D96B27] hover:underline">Tours & Packages</a>
                            to see suggestions here.
                        </p>
                    @else
                        <ul class="mt-2 divide-y divide-black/5 text-xs dark:divide-white/5">
                            @foreach ($matchingTours as $match)
                                <li class="flex flex-wrap items-center justify-between gap-3 py-3">
                                    <div>
                                        <a href="{{ route('admin.tours.edit', $match) }}" class="font-bold text-[#211915] hover:text-[#D96B27] dark:text-white">{{ $match->title }}</a>
                                        <p class="mt-0.5 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                            {{ $match->duration_days }} Days / {{ $match->duration_nights }} Nights
                                            &bull; Matches {{ $match->matching_experiences_count }} of {{ $inquiry->experiences->count() }} experiences
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-[#D96B27]">From {{ $match->formatted_price }}</p>
                                        <a href="{{ route('tours.show', $match) }}" target="_blank" class="text-[11px] text-[#6E635C] hover:underline dark:text-[#FAF6F0]/60">View live ↗</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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

            <!-- Right Column: Follow-up History, Status & Audit -->
            <div class="space-y-6">
                @php
                    $statusColours = [
                        'new' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400',
                        'contacted' => 'bg-[#D96B27]/10 text-[#BF5A1B] dark:text-[#D96B27]',
                        'quote_sent' => 'bg-amber-500/10 text-amber-700 dark:text-amber-400',
                        'confirmed' => 'bg-blue-500/10 text-blue-700 dark:text-blue-400',
                        'cancelled' => 'bg-rose-500/10 text-rose-700 dark:text-rose-400',
                    ];
                @endphp

                <!-- Follow-up History (append-only, staff only) -->
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex items-baseline justify-between border-b border-black/10 pb-3 dark:border-white/10">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Follow-up History</h3>
                        <span class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                            {{ $inquiry->updates->count() }} {{ \Illuminate\Support\Str::plural('update', $inquiry->updates->count()) }}
                        </span>
                    </div>

                    @if ($inquiry->updates->isEmpty())
                        <p class="mt-4 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                            No follow-ups yet. Record each call, message or quote below so the whole team can see where this guest stands.
                        </p>
                    @else
                        <ol class="mt-4 max-h-[28rem] space-y-4 overflow-y-auto pr-1">
                            @foreach ($inquiry->updates as $update)
                                <li class="border-l-2 border-[#D96B27]/30 pl-3">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @if ($update->isStatusChange())
                                            <span class="rounded-xs px-1.5 py-0.5 text-[10px] font-bold {{ $statusColours[$update->previous_status] ?? 'bg-black/5' }} line-through opacity-70">
                                                {{ \App\Models\Inquiry::STATUSES[$update->previous_status]['short'] ?? $update->previous_status }}
                                            </span>
                                            <span class="text-[10px] text-[#6E635C]" aria-label="changed to">&rarr;</span>
                                        @endif
                                        <span class="rounded-xs px-1.5 py-0.5 text-[10px] font-bold {{ $statusColours[$update->status] ?? 'bg-black/5' }}">
                                            {{ $update->status_label }}
                                        </span>
                                    </div>
                                    @if ($update->note)
                                        <p class="mt-1.5 whitespace-pre-line text-xs leading-relaxed text-[#211915] dark:text-white">{{ $update->note }}</p>
                                    @elseif ($update->isStatusChange())
                                        <p class="mt-1.5 text-xs italic text-[#6E635C] dark:text-[#FAF6F0]/60">Status changed.</p>
                                    @endif
                                    <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                        <span class="font-semibold text-[#211915] dark:text-[#FAF6F0]/90">{{ $update->author_name }}</span>
                                        @if ($update->author_role)
                                            ({{ $update->author_role }})
                                        @endif
                                        &bull;
                                        <time datetime="{{ $update->created_at->toIso8601String() }}">{{ $update->created_at->timezone('Africa/Nairobi')->format('d M Y, H:i') }} EAT</time>
                                    </p>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>

                <!-- Status & Follow-up Form -->
                <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="border-b border-black/10 pb-3 text-xs font-bold uppercase tracking-wider text-[#D96B27] dark:border-white/10">
                        Inquiry Status & Operations
                    </h3>

                    <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Status
                            </label>
                            <select id="status" name="status"
                                class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-xs font-semibold text-[#211915] outline-none focus:border-[#D96B27] focus:ring-1 focus:ring-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                                @foreach (\App\Models\Inquiry::STATUSES as $value => $status)
                                    <option value="{{ $value }}" @selected(old('status', $inquiry->status) === $value)>{{ $status['label'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="note" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                                Follow-up Note
                            </label>
                            <textarea id="note" name="note" rows="4" maxlength="5000"
                                placeholder="e.g. Did not pick up the call. Will try again at 4pm."
                                class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-xs text-[#211915] outline-none focus:border-[#D96B27] focus:ring-1 focus:ring-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('note') }}</textarea>
                            <x-form-error name="note" />
                            <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                Saved under your name with the time. Visible only to Gentriiq staff, never to the guest.
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full rounded-sm bg-[#D96B27] py-2.5 text-xs font-bold text-white shadow-xs transition-colors hover:bg-[#BF5A1B]">
                            Save Update
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
                        <li>Last Updated: {{ $inquiry->updated_at->timezone('Africa/Nairobi')->format('M d, Y H:i') }} (EAT)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin>
