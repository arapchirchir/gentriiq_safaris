<x-layouts.admin :title="'Edit Tour: ' . $tour->title">

    <div class="space-y-6 max-w-4xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tours.index') }}"
                    class="inline-flex size-8 items-center justify-center rounded-sm border border-black/10 bg-white text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                    &larr;
                </a>
                <div>
                    <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">
                        Edit Safari Package
                    </h2>
                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                        {{ $tour->title }} &bull; Slug: <span class="font-mono">{{ $tour->slug }}</span>
                    </p>
                </div>
            </div>

            <a href="{{ route('tours.show', $tour) }}" target="_blank"
                class="inline-flex items-center gap-1.5 rounded-sm border border-black/10 bg-white px-3 py-2 text-xs font-bold text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                <span>View Live Package ↗</span>
            </a>
        </div>

        <form method="POST" action="{{ route('admin.tours.update', $tour) }}"
            class="rounded-sm border border-black/10 bg-white p-6 shadow-xs space-y-6 dark:border-white/10 dark:bg-[#24140E]">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Tour Title *
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $tour->title) }}" required
                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Short Summary (Hero / Cards) *
                </label>
                <textarea id="short_description" name="short_description" rows="2" required
                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-xs text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('short_description', $tour->short_description) }}</textarea>
            </div>

            <!-- Full Description -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                    Detailed Overview *
                </label>
                <textarea id="description" name="description" rows="6" required
                    class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-xs text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('description', $tour->description) }}</textarea>
            </div>

            <!-- Grid: Price, Tour Type, Status -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <label for="starting_price" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Starting Price (USD) *
                    </label>
                    <input type="number" step="1" min="0" id="starting_price" name="starting_price"
                        value="{{ old('starting_price', $tour->starting_price) }}" required
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-xs font-bold text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                </div>

                <div>
                    <label for="tour_type" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Tour Type *
                    </label>
                    <select id="tour_type" name="tour_type"
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-xs font-semibold text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <option value="both" @selected(old('tour_type', $tour->tour_type) === 'both')>Private & Group</option>
                        <option value="private" @selected(old('tour_type', $tour->tour_type) === 'private')>Private Safari Only</option>
                        <option value="group" @selected(old('tour_type', $tour->tour_type) === 'group')>Group Safari Only</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Publication Status *
                    </label>
                    <select id="status" name="status"
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-xs font-semibold text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                        <option value="published" @selected(old('status', $tour->status) === 'published')>Published (Live)</option>
                        <option value="draft" @selected(old('status', $tour->status) === 'draft')>Draft (Hidden)</option>
                        <option value="archived" @selected(old('status', $tour->status) === 'archived')>Archived</option>
                    </select>
                </div>
            </div>

            <!-- Featured Checkbox -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="featured" name="featured" value="1" @checked(old('featured', $tour->featured))
                    class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                <label for="featured" class="text-xs font-bold text-[#211915] dark:text-white">
                    Show as Featured Tour on Homepage
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-black/10 pt-4 dark:border-white/10">
                <a href="{{ route('admin.tours.index') }}"
                    class="rounded-sm border border-black/20 px-4 py-2 text-xs font-semibold text-[#6E635C] hover:bg-black/5 dark:border-white/20 dark:text-[#FAF6F0]/70">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-sm bg-[#D96B27] px-6 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                    Save Tour Changes
                </button>
            </div>
        </form>
    </div>

</x-layouts.admin>
