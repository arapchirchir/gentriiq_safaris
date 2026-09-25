<x-layouts.admin title="Tours & Safari Packages">

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">
                    Tours & Safari Packages
                </h2>
                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Manage safari itineraries, pricing tiers, and published visibility.
                </p>
            </div>
            <a href="{{ route('admin.tours.create') }}"
                class="inline-flex items-center gap-1.5 rounded-sm bg-[#D96B27] px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                + New Tour
            </a>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap gap-2 border-b border-black/10 pb-3 dark:border-white/10">
            @php
                $tabs = [
                    null => ['label' => 'All Tours', 'count' => $counts['all']],
                    'published' => ['label' => 'Published', 'count' => $counts['published']],
                    'draft' => ['label' => 'Drafts', 'count' => $counts['draft']],
                    'archived' => ['label' => 'Archived', 'count' => $counts['archived']],
                ];
            @endphp

            @foreach ($tabs as $key => $tab)
                <a href="{{ route('admin.tours.index', array_filter(['status' => $key])) }}"
                    class="inline-flex items-center gap-1.5 rounded-sm px-3 py-1.5 text-xs font-bold transition-colors
                    {{ ($status === $key || (!$status && $key === null))
                        ? 'bg-[#D96B27] text-white shadow-xs'
                        : 'bg-white text-[#6E635C] hover:bg-black/5 dark:bg-[#24140E] dark:text-[#FAF6F0]/70 dark:hover:bg-white/5' }}">
                    <span>{{ $tab['label'] }}</span>
                    <span class="rounded-full px-1.5 py-0.2 text-[10px] {{ ($status === $key || (!$status && $key === null)) ? 'bg-white/20 text-white' : 'bg-black/5 dark:bg-white/10' }}">
                        {{ $tab['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Tours Table Card -->
        <div class="rounded-sm border border-black/10 bg-white shadow-xs dark:border-white/10 dark:bg-[#24140E]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-black/10 text-left text-xs dark:divide-white/10">
                    <thead class="bg-[#FAF6F0] uppercase font-bold text-[#6E635C] dark:bg-black/20 dark:text-[#FAF6F0]/60">
                        <tr>
                            <th class="py-3.5 px-4">Tour Title & Itinerary</th>
                            <th class="py-3.5 px-4">Destinations</th>
                            <th class="py-3.5 px-4">Duration</th>
                            <th class="py-3.5 px-4">From Price</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5 font-medium text-[#211915] dark:text-white">
                        @forelse ($tours as $tour)
                            <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($tour->hero_image)
                                            <img src="{{ $tour->hero_image }}" alt="{{ $tour->title }}"
                                                class="size-10 rounded-sm object-cover shrink-0">
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.tours.edit', $tour) }}" class="font-bold text-[#211915] hover:text-[#D96B27] dark:text-white">
                                                {{ $tour->title }}
                                            </a>
                                            @if ($tour->featured)
                                                <span class="ml-1 inline-flex items-center rounded-xs bg-[#D96B27]/10 px-1.5 py-0.2 text-[10px] font-bold text-[#D96B27]">
                                                    Featured
                                                </span>
                                            @endif
                                            <div class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60 line-clamp-1">
                                                {{ $tour->short_description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    @foreach ($tour->destinations as $dest)
                                        <span class="inline-block rounded-xs bg-black/5 px-1.5 py-0.5 text-[10px] text-[#211915] dark:bg-white/10 dark:text-white">
                                            {{ $dest->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    {{ $tour->duration_days }} Days / {{ $tour->duration_nights }} Nights
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap font-bold text-[#D96B27]">
                                    ${{ number_format($tour->starting_price) }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-sm px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider
                                        {{ $tour->status === 'published' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-zinc-500/10 text-zinc-600 dark:text-zinc-400' }}">
                                        {{ $tour->status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('tours.show', $tour) }}" target="_blank"
                                        class="inline-flex items-center rounded-sm border border-black/10 bg-white px-2.5 py-1 text-[11px] font-semibold text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#180D08] dark:text-white">
                                        View Live
                                    </a>
                                    <a href="{{ route('admin.tours.edit', $tour) }}"
                                        class="inline-flex items-center rounded-sm bg-[#D96B27] px-2.5 py-1 text-[11px] font-bold text-white hover:bg-[#BF5A1B]">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-[#6E635C] dark:text-[#FAF6F0]/60">
                                    No tours found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tours->hasPages())
                <div class="border-t border-black/10 p-4 dark:border-white/10">
                    {{ $tours->links() }}
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>
