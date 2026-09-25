<x-layouts.admin title="Experiences">

    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">Experiences</h2>
                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Shown on the homepage, offered in the trip planner, and used to tag tours for quote suggestions.
                </p>
            </div>
            <a href="{{ route('admin.experiences.create') }}"
                class="inline-flex items-center gap-1.5 rounded-sm bg-[#D96B27] px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                + New Experience
            </a>
        </div>

        {{-- Table --}}
        <div class="rounded-sm border border-black/10 bg-white shadow-xs dark:border-white/10 dark:bg-[#24140E]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-black/10 text-left text-xs dark:divide-white/10">
                    <thead class="bg-[#FAF6F0] uppercase font-bold text-[#6E635C] dark:bg-black/20 dark:text-[#FAF6F0]/60">
                        <tr>
                            <th class="py-3.5 px-4">Experience</th>
                            <th class="py-3.5 px-4">Trip Planner</th>
                            <th class="py-3.5 px-4">Homepage</th>
                            <th class="py-3.5 px-4">Tours</th>
                            <th class="py-3.5 px-4">Inquiries</th>
                            <th class="py-3.5 px-4">Sort</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5 font-medium text-[#211915] dark:text-white">
                        @forelse ($experiences as $experience)
                            <tr class="hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($experience->image)
                                            <img src="{{ $experience->image }}" alt="{{ $experience->name }}"
                                                class="size-10 rounded-sm object-cover shrink-0">
                                        @else
                                            <div class="size-10 rounded-sm bg-black/10 dark:bg-white/10 shrink-0"></div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.experiences.edit', $experience) }}"
                                                class="font-bold text-[#211915] hover:text-[#D96B27] dark:text-white">
                                                {{ $experience->name }}
                                            </a>
                                            <div class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60 font-mono">
                                                {{ $experience->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @foreach ([$experience->show_in_planner, $experience->featured] as $visible)
                                    <td class="py-3.5 px-4">
                                        @if ($visible)
                                            <span class="inline-flex items-center rounded-sm bg-emerald-500/10 px-2 py-0.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">Shown</span>
                                        @else
                                            <span class="text-[#6E635C] dark:text-[#FAF6F0]/60 text-[11px]">Hidden</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="py-3.5 px-4">
                                    <span class="rounded-full bg-black/5 px-2 py-0.5 text-[11px] dark:bg-white/10">{{ $experience->tours_count }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="rounded-full bg-black/5 px-2 py-0.5 text-[11px] dark:bg-white/10">{{ $experience->inquiries_count }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-[#6E635C] dark:text-[#FAF6F0]/70">{{ $experience->sort_order }}</td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.experiences.edit', $experience) }}"
                                        class="inline-flex items-center rounded-sm bg-[#D96B27] px-2.5 py-1 text-[11px] font-bold text-white hover:bg-[#BF5A1B]">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-[#6E635C] dark:text-[#FAF6F0]/60">
                                    No experiences yet.
                                    <a href="{{ route('admin.experiences.create') }}" class="ml-1 text-[#D96B27] hover:underline">Create the first one.</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($experiences->hasPages())
                <div class="border-t border-black/10 p-4 dark:border-white/10">
                    {{ $experiences->links() }}
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>
