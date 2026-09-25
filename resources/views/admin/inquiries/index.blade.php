<x-layouts.admin title="Safari plans & Inquiries">

    <div class="space-y-6">
        <!-- Page Header & Filters -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">
                    Safari plans & Customer Inquiries
                </h2>
                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Manage guest requests, send quotes, and track customer negotiations.
                </p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex items-center gap-2">
                @if ($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <div class="relative">
                    <input type="text" name="q" value="{{ $search }}"
                        placeholder="Search guest or ref..."
                        class="w-56 rounded-sm border border-black/20 bg-white py-2 pl-3 pr-8 text-xs text-[#211915] outline-none focus:border-[#D96B27] focus:ring-1 focus:ring-[#D96B27] dark:border-white/20 dark:bg-[#24140E] dark:text-white">
                    @if ($search)
                        <a href="{{ route('admin.inquiries.index', array_filter(['status' => $status])) }}"
                            class="absolute right-2.5 top-2 text-[#6E635C] hover:text-[#211915] dark:text-white/60">
                            &times;
                        </a>
                    @endif
                </div>
                <button type="submit"
                    class="rounded-sm bg-[#24140E] px-3 py-2 text-xs font-semibold text-white hover:bg-black dark:bg-[#D96B27] dark:hover:bg-[#BF5A1B]">
                    Search
                </button>
            </form>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap gap-2 border-b border-black/10 pb-3 dark:border-white/10">
            @php
                $tabs = [
                    null => ['label' => 'All Inquiries', 'count' => $statusCounts['all']],
                    'new' => ['label' => 'New', 'count' => $statusCounts['new']],
                    'contacted' => ['label' => 'Contacted', 'count' => $statusCounts['contacted']],
                    'quote_sent' => ['label' => 'Quote Sent', 'count' => $statusCounts['quote_sent']],
                    'confirmed' => ['label' => 'Confirmed', 'count' => $statusCounts['confirmed']],
                    'cancelled' => ['label' => 'Cancelled', 'count' => $statusCounts['cancelled']],
                ];
            @endphp

            @foreach ($tabs as $key => $tab)
                <a href="{{ route('admin.inquiries.index', array_filter(['status' => $key, 'q' => $search])) }}"
                    class="inline-flex items-center gap-1.5 rounded-sm px-3 py-1.5 text-xs font-bold transition-colors
                    {{ $status === $key || (!$status && $key === null)
                        ? 'bg-[#D96B27] text-white shadow-xs'
                        : 'bg-white text-[#6E635C] hover:bg-black/5 dark:bg-[#24140E] dark:text-[#FAF6F0]/70 dark:hover:bg-white/5' }}">
                    <span>{{ $tab['label'] }}</span>
                    <span
                        class="rounded-full px-1.5 py-0.2 text-[10px] {{ $status === $key || (!$status && $key === null) ? 'bg-white/20 text-white' : 'bg-black/5 dark:bg-white/10' }}">
                        {{ $tab['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Inquiries Table Card -->
        <div class="rounded-sm border border-black/10 bg-white shadow-xs dark:border-white/10 dark:bg-[#24140E]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-black/10 text-left text-xs dark:divide-white/10">
                    <thead
                        class="bg-[#FAF6F0] uppercase font-bold text-[#6E635C] dark:bg-black/20 dark:text-[#FAF6F0]/60">
                        <tr>
                            <th class="py-3.5 px-4">Ref & Date</th>
                            <th class="py-3.5 px-4">Guest Information</th>
                            <th class="py-3.5 px-4">Trip Focus</th>
                            <th class="py-3.5 px-4">Travel Window</th>
                            <th class="py-3.5 px-4">Duration & Party</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-black/5 dark:divide-white/5 font-medium text-[#211915] dark:text-white">
                        @forelse ($inquiries as $inquiry)
                            <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                <td class="py-3.5 px-4">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                        class="font-mono font-bold text-[#D96B27] hover:underline">
                                        {{ $inquiry->reference }}
                                    </a>
                                    <div class="text-[10px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                        {{ $inquiry->created_at->format('M d, Y H:i') }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold">{{ $inquiry->name }}</div>
                                    <div class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                        {{ $inquiry->email }}</div>
                                    @if ($inquiry->phone)
                                        <div class="text-[11px] text-[#D96B27]">{{ $inquiry->phone }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold">{{ $inquiry->experiences_label }}</div>
                                    @if ($inquiry->tour)
                                        <div class="text-[10px] text-[#D96B27] font-bold">{{ $inquiry->tour->title }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div>
                                        {{ $inquiry->travel_date?->format('M d, Y') ?? $inquiry->travel_month . ' ' . $inquiry->travel_year }}
                                    </div>
                                    @if ($inquiry->travel_season)
                                        <div class="text-[10px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                            {{ $inquiry->travel_season }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div>{{ $inquiry->duration_label }}</div>
                                    <div class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                                        {{ $inquiry->traveller_label }}</div>
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
                                <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                        class="inline-flex items-center rounded-sm bg-[#D96B27] px-2.5 py-1 text-[11px] font-bold text-white hover:bg-[#BF5A1B]">
                                        Open Plan
                                    </a>
                                    @if ($inquiry->phone)
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $inquiry->phone);
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                                            class="inline-flex items-center rounded-sm bg-[#25D366] px-2.5 py-1 text-[11px] font-bold text-white hover:bg-[#20ba59]"
                                            title="Chat with Guest on WhatsApp">
                                            WhatsApp
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-[#6E635C] dark:text-[#FAF6F0]/60">
                                    No inquiries found matching this criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($inquiries->hasPages())
                <div class="border-t border-black/10 p-4 dark:border-white/10">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>
