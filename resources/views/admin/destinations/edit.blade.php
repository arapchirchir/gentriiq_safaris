<x-layouts.admin :title="'Edit: ' . $destination->name">

    <div class="space-y-6 w-full">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.destinations.index') }}"
                    class="inline-flex size-8 items-center justify-center rounded-sm border border-black/10 bg-white text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                    &larr;
                </a>
                <div>
                    <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">Edit Destination</h2>
                    <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                        {{ $destination->name }} &bull; Slug: <span class="font-mono">{{ $destination->slug }}</span>
                        @if($destination->tours_count > 0)
                            &bull; Used in {{ $destination->tours_count }} tour{{ $destination->tours_count !== 1 ? 's' : '' }}
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('destinations.show', $destination) }}" target="_blank"
                class="inline-flex items-center gap-1.5 rounded-sm border border-black/10 bg-white px-3 py-2 text-xs font-bold text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                View Live ↗
            </a>
        </div>

        <form id="destination-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.destinations.update', $destination) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Core Fields --}}
            <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Core Details</h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Name *</label>
                        <input type="text" name="name" value="{{ old('name', $destination->name) }}" required
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Country</label>
                        <input type="text" name="country" maxlength="100" value="{{ old('country', $destination->country) }}"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Short Summary *</label>
                    <textarea name="summary" rows="2" required maxlength="500"
                        class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('summary', $destination->summary) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70 mb-1.5">Full Description</label>
                    <x-tiptap-editor name="description" :content="old('description', $destination->description ?? '')" />
                </div>
            </div>

            {{-- Image --}}
            <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                <x-photo-field name="image" label="Image" :value="old('image', $destination->image)" />
            </div>

            {{-- Visibility --}}
            <div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Visibility</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Featured Badge</label>
                        <input type="text" name="featured_badge" maxlength="50" value="{{ old('featured_badge', $destination->featured_badge) }}"
                            placeholder="e.g. Top Pick"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Sort Order</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $destination->sort_order ?? 0) }}"
                            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="featured" value="1" @checked(old('featured', $destination->featured))
                                class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                            <span class="text-xs font-bold text-[#211915] dark:text-white">Featured on Homepage</span>
                        </label>
                    </div>
                </div>
            </div>

        </form>

        {{-- Delete form (outside main form to avoid nesting) --}}
        <form id="delete-destination-form" method="POST" action="{{ route('admin.destinations.destroy', $destination) }}"
            onsubmit="return confirm('Delete this destination permanently?')">
            @csrf @method('DELETE')
        </form>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-3 pb-8">
            <button type="submit" form="delete-destination-form"
                class="rounded-sm border border-red-500/30 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-500/10">
                Delete Destination
            </button>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.destinations.index') }}"
                    class="rounded-sm border border-black/20 px-4 py-2 text-xs font-semibold text-[#6E635C] hover:bg-black/5 dark:border-white/20 dark:text-[#FAF6F0]/70">
                    Cancel
                </a>
                <button type="submit" form="destination-form"
                    class="rounded-sm bg-[#D96B27] px-6 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                    Save Changes
                </button>
            </div>
        </div>
    </div>

</x-layouts.admin>
