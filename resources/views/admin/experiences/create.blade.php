<x-layouts.admin title="New Experience">

    <div class="space-y-6 w-full">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.experiences.index') }}"
                class="inline-flex size-8 items-center justify-center rounded-sm border border-black/10 bg-white text-[#211915] hover:bg-black/5 dark:border-white/10 dark:bg-[#24140E] dark:text-white">
                &larr;
            </a>
            <div>
                <h2 class="text-xl font-black text-[#211915] sm:text-2xl dark:text-white">New Experience</h2>
                <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Experiences appear on the homepage, in the trip planner, and as tour tags.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.experiences.store') }}" class="space-y-6">
            @csrf
            @include('admin.experiences._form', ['experience' => new \App\Models\Experience(['show_in_planner' => true])])

            <div class="flex items-center justify-end gap-3 pb-8">
                <a href="{{ route('admin.experiences.index') }}"
                    class="rounded-sm border border-black/20 px-4 py-2 text-xs font-semibold text-[#6E635C] hover:bg-black/5 dark:border-white/20 dark:text-[#FAF6F0]/70">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-sm bg-[#D96B27] px-6 py-2 text-xs font-bold text-white shadow-xs hover:bg-[#BF5A1B]">
                    Create Experience
                </button>
            </div>
        </form>
    </div>

</x-layouts.admin>
