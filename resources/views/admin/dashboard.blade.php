<x-layouts.admin title="Dashboard Overview">

    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div
            class="flex flex-col justify-between gap-4 rounded-sm border border-black/10 bg-white p-6 shadow-xs sm:flex-row sm:items-center dark:border-white/10 dark:bg-[#24140E]">
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">
                    Jambo, {{ auth()->user()->name }}!
                </h2>
                <p class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Gentriiq Safaris operations desk. Here is your current performance snapshot{{ $canSeeInquiries ? ' and customer inquiries' : '' }}.
                </p>
            </div>
            @if ($canSeeInquiries)
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.inquiries.index') }}"
                    class="inline-flex items-center gap-2 rounded-sm bg-[#D96B27] px-4 py-2.5 text-xs font-bold text-white shadow-xs transition-colors hover:bg-[#BF5A1B]">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>View All Inquiries</span>
                </a>
            </div>
            @endif
        </div>

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @if ($canSeeInquiries)
            <!-- Total Inquiries -->
            <div
                class="rounded-sm border border-black/10 bg-white p-5 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Total
                        Proposals</span>
                    <span class="rounded-full bg-[#D96B27]/10 p-2 text-[#D96B27]">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-[#211915] dark:text-white">{{ $metrics['total_inquiries'] }}</p>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">All Time</span>
                </div>
            </div>

            <!-- New / Pending Inquiries -->
            <div
                class="rounded-sm border border-[#D96B27]/30 bg-white p-5 shadow-xs dark:border-[#D96B27]/30 dark:bg-[#24140E]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">New Inquiries</span>
                    <span class="rounded-full bg-[#D96B27]/20 p-2 text-[#D96B27]">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-[#D96B27]">{{ $metrics['new_inquiries'] }}</p>
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">Requires Follow-up</span>
                </div>
            </div>

            @endif
            <!-- Active Safari Packages -->
            <div
                class="rounded-sm border border-black/10 bg-white p-5 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Published
                        Tours</span>
                    <span class="rounded-full bg-[#D96B27]/10 p-2 text-[#D96B27]">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                        </svg>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-[#211915] dark:text-white">{{ $metrics['published_tours'] }}</p>
                    <span class="text-xs font-semibold text-[#6E635C] dark:text-[#FAF6F0]/60">Of
                        {{ $metrics['total_tours'] }} Total</span>
                </div>
            </div>

            <!-- Destinations -->
            <div
                class="rounded-sm border border-black/10 bg-white p-5 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/60">Destinations</span>
                    <span class="rounded-full bg-[#D96B27]/10 p-2 text-[#D96B27]">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <p class="text-3xl font-black text-[#211915] dark:text-white">{{ $metrics['total_destinations'] }}
                    </p>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Kenya & Tanzania</span>
                </div>
            </div>
        </div>

        @if ($canSeeInquiries)
        <!-- Recent Inquiries Section -->
        <div class="rounded-sm border border-black/10 bg-white shadow-xs dark:border-white/10 dark:bg-[#24140E]">
            <div
                class="flex flex-wrap items-center justify-between gap-4 border-b border-black/10 p-5 dark:border-white/10">
                <div>
                    <h3 class="text-base font-bold text-[#211915] dark:text-white">Recent Safari plans</h3>
                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Latest requests submitted through the
                        online trip planner.</p>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-[#D96B27] hover:underline">
                    View full list &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-black/10 text-left text-xs dark:divide-white/10">
                    <thead
                        class="bg-[#FAF6F0] uppercase font-bold text-[#6E635C] dark:bg-black/20 dark:text-[#FAF6F0]/60">
                        <tr>
                            <th class="py-3.5 px-4">Reference</th>
                            <th class="py-3.5 px-4">Guest</th>
                            <th class="py-3.5 px-4">Party</th>
                            <th class="py-3.5 px-4">Duration</th>
                            <th class="py-3.5 px-4">Travel Date</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-black/5 dark:divide-white/5 font-medium text-[#211915] dark:text-white">
                        @forelse ($recentInquiries as $inquiry)
                            <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-bold text-[#D96B27]">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="hover:underline">
                                        {{ $inquiry->reference }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold">{{ $inquiry->name }}</div>
                                    <div class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                        {{ $inquiry->email }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    {{ $inquiry->traveller_label }}
                                </td>
                                <td class="py-3.5 px-4">
                                    {{ $inquiry->duration_label }}
                                </td>
                                <td class="py-3.5 px-4">
                                    {{ $inquiry->travel_date?->format('M d, Y') ?? $inquiry->travel_month . ' ' . $inquiry->travel_year }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span
                                        class="inline-flex items-center rounded-sm px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider
                                        @if ($inquiry->status === 'new') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400
                                        @elseif($inquiry->status === 'confirmed') bg-blue-500/10 text-blue-600 dark:text-blue-400
                                        @elseif($inquiry->status === 'quote_sent') bg-amber-500/10 text-amber-600 dark:text-amber-400
                                        @elseif($inquiry->status === 'cancelled') bg-rose-500/10 text-rose-600 dark:text-rose-400
                                        @else bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-2">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                        class="inline-flex items-center rounded-sm border border-black/10 bg-white px-2.5 py-1 text-[11px] font-semibold text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#180D08] dark:text-white">
                                        View Dossier
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-[#6E635C] dark:text-[#FAF6F0]/60">
                                    No inquiries submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

</x-layouts.admin>
