<x-layouts.public :title="$destination->name" :description="$destination->summary" :ogImage="$destination->image">
    <div class="bg-[#FAF6F0] py-12 dark:bg-[#180D08] sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-8 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">
                <a href="{{ route('home') }}" class="hover:text-[#D96B27]">Home</a>
                <span class="mx-2">/</span>
                <span class="text-[#211915] dark:text-white">{{ $destination->name }}</span>
            </nav>

            <div class="grid gap-10 lg:grid-cols-[1.25fr_0.75fr] lg:items-center">
                <div class="relative aspect-16/9 overflow-hidden rounded-sm bg-black">
                    <img src="{{ $destination->image }}" alt="{{ $destination->name }}" class="size-full object-cover">
                </div>
                <div>
                    @if ($destination->featured_badge)
                        <p class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">
                            {{ $destination->featured_badge }}</p>
                    @endif
                    <h1 class="mt-2 text-4xl font-extrabold text-[#211915] dark:text-white sm:text-5xl">
                        {{ $destination->name }}</h1>
                    <p class="mt-5 text-base leading-7 text-[#6E635C] dark:text-[#FAF6F0]/70">
                        {{ $destination->description ?: $destination->summary }}</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <x-button href="{{ route('plan.create', ['destination' => $destination->slug]) }}"
                            variant="primary" size="lg">
                            Plan This Destination
                        </x-button>
                        <a href="https://wa.me/254717838061?text={{ urlencode('Hello Gentriiq Safaris & Tours, tell me more about ' . $destination->name . ' tours: ' . route('destinations.show', $destination)) }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-sm border border-[#D96B27] px-5 py-3 text-sm font-semibold text-[#D96B27] transition-colors hover:bg-[#D96B27]/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
                            Inquire on WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <section class="mt-16 border-t border-black/10 pt-12 dark:border-white/10">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Plan your journey</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-[#211915] dark:text-white">Packages featuring {{ $destination->name }}</h2>
                    </div>
                </div>
                <div class="mt-8 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($destination->tours as $tour)
                        <article
                            class="overflow-hidden rounded-sm border border-black/10 bg-white shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                            <a href="{{ route('tours.show', $tour) }}"
                                class="block aspect-16/10 focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#D96B27]">
                                <img src="{{ $tour->hero_image }}" alt="{{ $tour->title }}"
                                    class="size-full object-cover">
                            </a>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-wider text-[#D96B27]">
                                    {{ $tour->duration_days }} Days / {{ $tour->duration_nights }} Nights</p>
                                <h3 class="mt-2 text-xl font-bold text-[#211915] dark:text-white"><a
                                        href="{{ route('tours.show', $tour) }}"
                                        class="hover:text-[#D96B27]">{{ $tour->title }}</a></h3>
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-[#6E635C] dark:text-[#FAF6F0]/70">
                                    {{ $tour->short_description }}</p>
                                <div
                                    class="mt-5 flex items-center justify-between gap-3 border-t border-black/10 pt-4 dark:border-white/10">
                                    <span class="text-sm font-bold text-[#D96B27]">{{ $tour->formatted_price }}</span>
                                    <a href="{{ route('plan.create', ['tour' => $tour->slug, 'destination' => $destination->slug]) }}"
                                        class="text-xs font-bold text-[#D96B27] hover:underline">Plan this safari
                                        &rarr;</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">Packages for this destination are being
                            prepared. Contact our safari desk for a tailored itinerary.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-layouts.public>
