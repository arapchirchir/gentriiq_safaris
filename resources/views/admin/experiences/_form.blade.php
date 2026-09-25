{{-- Shared create/edit fields. Expects $experience (a new or existing Experience). --}}
<div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-5">
    <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Core Details</h3>

    <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Name *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $experience->name) }}" required maxlength="255"
            placeholder="e.g. Great Migration Safaris"
            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
        <x-form-error name="name" />
    </div>

    <div>
        <label for="summary" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Short Summary</label>
        <textarea id="summary" name="summary" rows="2" maxlength="500"
            placeholder="One sentence shown on the homepage and in the trip planner."
            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white p-3 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">{{ old('summary', $experience->summary) }}</textarea>
        <x-form-error name="summary" />
    </div>
</div>

<div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4"
    x-data="{ url: @js(old('image', $experience->image)) }">
    <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Photo</h3>
    <div>
        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Image URL</label>
        <input type="url" id="image" name="image" x-model="url" maxlength="255"
            placeholder="https://images.unsplash.com/..."
            class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
        <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Use a real photo — experiences are shown as image tiles.</p>
        <x-form-error name="image" />
    </div>
    <div x-show="url" class="mt-3">
        <img :src="url" alt="Image preview" class="h-48 w-full rounded-sm object-cover">
    </div>
</div>

<div class="rounded-sm border border-black/10 bg-white p-6 shadow-xs dark:border-white/10 dark:bg-[#24140E] space-y-4">
    <h3 class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Visibility</h3>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div>
            <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $experience->sort_order ?? 0) }}"
                class="mt-1.5 w-full rounded-sm border border-black/20 bg-white px-3 py-2 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
            <x-form-error name="sort_order" />
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="show_in_planner" value="1" @checked(old('show_in_planner', $experience->show_in_planner))
                    class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                <span class="text-xs font-bold text-[#211915] dark:text-white">Show in Trip Planner</span>
            </label>
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="featured" value="1" @checked(old('featured', $experience->featured))
                    class="size-4 rounded-xs border-black/20 text-[#D96B27] focus:ring-[#D96B27]">
                <span class="text-xs font-bold text-[#211915] dark:text-white">Featured on Homepage</span>
            </label>
        </div>
    </div>
</div>
