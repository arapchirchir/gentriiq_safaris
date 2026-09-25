<x-layouts.admin :title="'Edit: ' . $experience->name">

    <div class="space-y-6 w-full">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.experiences.index') }}"
                class="inline-flex size-8 items-center justify-center rounded-sm border border-black/10 bg-white text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                &larr;
            </a>
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">Edit Experience</h2>
                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                    {{ $experience->name }} &bull; Slug: <span class="font-mono">{{ $experience->slug }}</span>
                    &bull; {{ $experience->tours_count }} {{ \Illuminate\Support\Str::plural('tour', $experience->tours_count) }}
                    &bull; {{ $experience->inquiries_count }} {{ \Illuminate\Support\Str::plural('inquiry', $experience->inquiries_count) }}
                </p>
            </div>
        </div>

        <x-form-error name="experience" />

        <form id="experience-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.experiences.update', $experience) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.experiences._form')
        </form>

        {{-- Delete form (outside main form to avoid nesting) --}}
        <form id="delete-experience-form" method="POST" action="{{ route('admin.experiences.destroy', $experience) }}"
            onsubmit="return confirm('Delete this experience permanently? Tours tagged with it will lose the tag.')">
            @csrf @method('DELETE')
        </form>

        <div class="flex items-center justify-between gap-3 pb-8">
            @if ($experience->inquiries_count === 0)
                <button type="submit" form="delete-experience-form"
                    class="rounded-sm border border-red-500/30 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-500/10">
                    Delete Experience
                </button>
            @else
                <p class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">
                    Chosen on guest inquiries, so it can't be deleted — untick the visibility options to hide it.
                </p>
            @endif
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.experiences.index') }}"
                    class="rounded-sm border border-black/20 px-4 py-2 text-xs font-semibold text-[#6E635C] hover:bg-black/5 dark:border-white/20 dark:text-[#FAF6F0]/70">
                    Cancel
                </a>
                <button type="submit" form="experience-form"
                    class="rounded-sm bg-[#D96B27] px-6 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                    Save Changes
                </button>
            </div>
        </div>
    </div>

</x-layouts.admin>
