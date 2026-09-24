<x-layouts.public title="Authentic East African Safaris & Tours">

    <!-- HERO SECTION -->
    <section class="relative min-h-[88vh] flex items-center justify-center overflow-hidden bg-[#180D08] text-white">
        <!-- Background Imagery with Ambient Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=2000&q=80"
                alt="Cheetah scanning savannah in Kenya" class="size-full object-cover object-center opacity-45">
            <div class="absolute inset-0 bg-gradient-to-t from-[#180D08] via-[#180D08]/60 to-black/40"></div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-transparent via-[#180D08]/40 to-[#180D08]">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 text-center sm:py-32">
            <!-- Main Headline -->
            <h1 class="mx-auto max-w-4xl text-4xl font-extrabold tracking-tight sm:text-6xl lg:text-7xl">
                Experience the Untamed Spirit of <span class="text-[#D96B27]">East Africa</span>
            </h1>

            <!-- Subtitle -->
            <p class="mx-auto mt-6 max-w-2xl text-base text-[#FAF6F0]/85 sm:text-xl sm:leading-relaxed">
                Tailor-made private safaris, breathtaking Great Migration expeditions, and luxury wildlife encounters
                across Kenya, Tanzania, Uganda, and Rwanda.
            </p>

            <!-- Hero Action Buttons -->
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <x-button href="#safaris" variant="primary" size="lg" class="min-w-44">
                    Explore Safaris
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </x-button>

                <x-button href="{{ route('plan.create') }}" variant="primary" size="lg" class="min-w-44">
                    <span>Plan My Safari</span>
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </x-button>
            </div>

            <!-- Key Proof Points Strip -->
            <div class="mt-16 grid grid-cols-2 gap-4 border-t border-white/10 pt-8 sm:grid-cols-4 sm:gap-8 text-left">
                <div class="rounded-sm bg-white/5 p-4 backdrop-blur-xs">
                    <p class="text-2xl font-bold text-[#D96B27]">100%</p>
                    <p class="mt-1 text-xs text-[#FAF6F0]/75">Bespoke & Tailor-Made Itineraries</p>
                </div>
                <div class="rounded-sm bg-white/5 p-4 backdrop-blur-xs">
                    <p class="text-2xl font-bold text-[#D96B27]">4x4</p>
                    <p class="mt-1 text-xs text-[#FAF6F0]/75">Custom Safari Land Cruisers Guaranteed</p>
                </div>
                <div class="rounded-sm bg-white/5 p-4 backdrop-blur-xs">
                    <p class="text-2xl font-bold text-[#D96B27]">15+ Yrs</p>
                    <p class="mt-1 text-xs text-[#FAF6F0]/75">Field Expertise by Local Naturalists</p>
                </div>
                <div class="rounded-sm bg-white/5 p-4 backdrop-blur-xs">
                    <p class="text-2xl font-bold text-[#D96B27]">24/7</p>
                    <p class="mt-1 text-xs text-[#FAF6F0]/75">Dedicated Trip & Field Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- POPULAR SAFARIS SECTION (DATABASE-DRIVEN) -->
    <section id="safaris" class="py-20 sm:py-28 bg-[#FAF6F0] dark:bg-[#180D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Handcrafted Journeys</span>
                    <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                        Featured Safari Packages
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm text-[#6E635C] sm:text-base dark:text-[#FAF6F0]/70">
                        Carefully designed wildlife itineraries offering the best balance of thrilling game viewing,
                        premier lodges, and authentic cultural immersion.
                    </p>
                </div>
                <x-button
                    href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris,%20can%20you%20share%20all%20available%20safari%20packages%3F"
                    target="_blank" rel="noopener noreferrer" variant="outline" size="md">
                    Request Custom Quote
                </x-button>
            </div>

            <!-- Dynamic Safari Tour Cards Grid -->
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($featuredTours as $tour)
                    <article
                        class="group flex flex-col overflow-hidden rounded-sm border border-black/10 bg-white shadow-xs transition-shadow duration-300 hover:shadow-lg dark:border-white/10 dark:bg-[#24140E]">
                        <div class="relative aspect-16/10 overflow-hidden bg-black/10">
                            <a href="{{ route('tours.show', $tour) }}"
                                class="block size-full focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#D96B27]"
                                aria-label="View {{ $tour->title }} details">
                                <img src="{{ $tour->hero_image }}" alt="{{ $tour->title }}" loading="lazy"
                                    class="size-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </a>
                            <div
                                class="absolute top-3 left-3 rounded-sm bg-[#24140E]/80 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-xs">
                                {{ $tour->duration_days }} Days / {{ $tour->duration_nights }} Nights
                            </div>
                            @if ($tour->badge)
                                <div
                                    class="absolute top-3 right-3 rounded-sm bg-[#D96B27] px-2.5 py-1 text-xs font-semibold text-white">
                                    {{ $tour->badge }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-center gap-2 text-xs font-medium text-[#D96B27]">
                                <span>{{ $tour->country }}</span>
                                @if ($tour->location_summary)
                                    <span>&bull;</span>
                                    <span>{{ $tour->location_summary }}</span>
                                @endif
                            </div>
                            <h3
                                class="mt-2 text-xl font-bold text-[#211915] transition-colors group-hover:text-[#D96B27] dark:text-white">
                                <a href="{{ route('tours.show', $tour) }}"
                                    class="focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
                                    {{ $tour->title }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-[#6E635C] line-clamp-2 dark:text-[#FAF6F0]/70">
                                {{ $tour->short_description }}
                            </p>

                            @if (!empty($tour->highlights))
                                <ul class="mt-4 space-y-1.5 text-xs text-[#211915]/80 dark:text-[#FAF6F0]/80">
                                    @foreach (array_slice($tour->highlights, 0, 2) as $highlight)
                                        <li class="flex items-center gap-2">
                                            <svg class="size-3.5 shrink-0 text-[#D96B27]" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>{{ $highlight }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div
                                class="mt-6 flex items-center justify-between border-t border-black/5 pt-4 dark:border-white/10">
                                <div>
                                    <span class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Starting from</span>
                                    <p class="text-lg font-extrabold text-[#D96B27]">{{ $tour->formatted_price }} <span
                                            class="text-xs font-normal text-[#6E635C] dark:text-[#FAF6F0]/60">/
                                            person</span></p>
                                </div>
                                <x-button
                                    href="https://wa.me/254717838061?text={{ urlencode('Hello Gentriiq Safaris & Tours, I am interested in booking the ' . $tour->title . ' package: ' . route('tours.show', $tour)) }}"
                                    target="_blank" rel="noopener noreferrer" variant="primary" size="sm">
                                    Inquire Now
                                </x-button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-full rounded-sm border border-black/10 bg-white p-12 text-center dark:border-white/10 dark:bg-[#24140E]">
                        <p class="text-base text-[#6E635C] dark:text-[#FAF6F0]/70">No safari packages currently
                            published. Please check back soon or contact our desk.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- WHY Gentriiq Safaris & Tours SECTION -->
    <section id="why-gentriiq" class="py-20 sm:py-28 bg-white dark:bg-[#1A0D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">The Gentriiq Advantage</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    Why Travel With Gentriiq Safaris & Tours?
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm text-[#6E635C] sm:text-base dark:text-[#FAF6F0]/70">
                    We don't just book safaris; we create deeply personal, unforgettable expeditions guided by deep
                    local knowledge and genuine East African hospitality.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    class="rounded-sm border border-black/10 bg-[#FAF6F0] p-6 transition-transform duration-200 hover:-translate-y-1 dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex size-12 items-center justify-center rounded-sm bg-[#D96B27] text-white">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-[#211915] dark:text-white">Local East African Experts</h3>
                    <p class="mt-2 text-sm text-[#6E635C] leading-relaxed dark:text-[#FAF6F0]/70">
                        Born and raised in East Africa, our safari naturalists track wildlife movements daily and know
                        every hidden corner of the national reserves.
                    </p>
                </div>

                <div
                    class="rounded-sm border border-black/10 bg-[#FAF6F0] p-6 transition-transform duration-200 hover:-translate-y-1 dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex size-12 items-center justify-center rounded-sm bg-[#D96B27] text-white">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-[#211915] dark:text-white">Direct Operator Pricing</h3>
                    <p class="mt-2 text-sm text-[#6E635C] leading-relaxed dark:text-[#FAF6F0]/70">
                        No middleman fees. You book directly with the local ground operator in Nairobi, ensuring the
                        best value and absolute accountability.
                    </p>
                </div>

                <div
                    class="rounded-sm border border-black/10 bg-[#FAF6F0] p-6 transition-transform duration-200 hover:-translate-y-1 dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex size-12 items-center justify-center rounded-sm bg-[#D96B27] text-white">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-[#211915] dark:text-white">Custom 4x4 Land Cruisers</h3>
                    <p class="mt-2 text-sm text-[#6E635C] leading-relaxed dark:text-[#FAF6F0]/70">
                        Equipped with pop-up game viewing roofs, charging outlets, binoculars, high-frequency radios,
                        and guaranteed window seating for every traveler.
                    </p>
                </div>

                <div
                    class="rounded-sm border border-black/10 bg-[#FAF6F0] p-6 transition-transform duration-200 hover:-translate-y-1 dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex size-12 items-center justify-center rounded-sm bg-[#D96B27] text-white">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-[#211915] dark:text-white">Responsible Safari Travel</h3>
                    <p class="mt-2 text-sm text-[#6E635C] leading-relaxed dark:text-[#FAF6F0]/70">
                        We actively support wildlife conservation trusts and partner directly with indigenous Maasai and
                        Samburu community conservancies.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ICONIC DESTINATIONS SECTION (DATABASE-DRIVEN) -->
    <section id="destinations" class="py-20 sm:py-28 bg-[#FAF6F0] dark:bg-[#180D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Explore the
                        Wilderness</span>
                    <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                        Iconic Safari Destinations
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm text-[#6E635C] sm:text-base dark:text-[#FAF6F0]/70">
                        From the rolling hills of the Maasai Mara to the volcanic peaks of the Great Rift Valley and the
                        white sand shores of the Indian Ocean.
                    </p>
                </div>
            </div>

            <!-- Dynamic Destinations Grid -->
            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($destinations as $destination)
                    <div class="group relative aspect-4/3 overflow-hidden rounded-sm bg-black">
                        <a href="{{ route('destinations.show', $destination) }}"
                            class="absolute inset-0 z-0 focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#D96B27]"
                            aria-label="View {{ $destination->name }} details">
                            <img src="{{ $destination->image }}" alt="{{ $destination->name }}" loading="lazy"
                                class="size-full object-cover transition-transform duration-500 group-hover:scale-110 opacity-75">
                        </a>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                            @if ($destination->featured_badge)
                                <span
                                    class="text-xs font-semibold uppercase tracking-wider text-[#D96B27]">{{ $destination->featured_badge }}</span>
                            @endif
                            <h3 class="mt-1 text-2xl font-bold">
                                <a href="{{ route('destinations.show', $destination) }}"
                                    class="focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
                                    {{ $destination->name }}
                                </a>
                            </h3>
                            <p class="mt-2 text-xs text-white/80 line-clamp-2">
                                {{ $destination->summary }}
                            </p>
                            <a href="https://wa.me/254717838061?text={{ urlencode('Hello Gentriiq Safaris & Tours, tell me more about ' . $destination->name . ' tours: ' . route('destinations.show', $destination)) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-[#D96B27] hover:underline">
                                Inquire About {{ $destination->name }} &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SIGNATURE EXPERIENCES SECTION (DATABASE-DRIVEN) -->
    <section id="experiences" class="py-20 sm:py-28 bg-white dark:bg-[#1A0D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Tailor Your Adventure</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    Signature Safari Experiences
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm text-[#6E635C] sm:text-base dark:text-[#FAF6F0]/70">
                    Whether you are travelling for wildlife photography, romantic honeymoons, or multi-generational
                    family holidays, we customize every detail.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6 text-center">
                @foreach ($experiences as $experience)
                    <div
                        class="rounded-sm border border-black/10 bg-[#FAF6F0] p-6 transition-all hover:border-[#D96B27] hover:shadow-md dark:border-white/10 dark:bg-[#24140E]">
                        <div
                            class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#D96B27]/15 text-[#D96B27]">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-sm font-bold text-[#211915] dark:text-white">{{ $experience->name }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section class="py-20 sm:py-28 bg-[#FAF6F0] dark:bg-[#180D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Guest Testimonials</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    Memories from the Savannah
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm text-[#6E635C] sm:text-base dark:text-[#FAF6F0]/70">
                    Discover why travelers from across the world trust Gentriiq Safaris & Tours for their East African
                    wildlife
                    journeys.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div
                    class="rounded-sm border border-black/10 bg-white p-8 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex text-[#D96B27]">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="size-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="mt-4 text-sm leading-relaxed text-[#211915]/90 dark:text-[#FAF6F0]/90">
                        &ldquo;Our 7-day Kenya Classic safari with Gentriiq Safaris & Tours exceeded every expectation!
                        Our
                        guide had an uncanny ability to spot leopards and cheetahs in the Mara. Everything was
                        seamless.&rdquo;
                    </blockquote>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-[#D96B27]/20 font-bold text-[#D96B27]">
                            SM
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#211915] dark:text-white">Sarah & Mark Thompson</p>
                            <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">United Kingdom &bull; Traveled
                                August 2025</p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-sm border border-black/10 bg-white p-8 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex text-[#D96B27]">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="size-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="mt-4 text-sm leading-relaxed text-[#211915]/90 dark:text-[#FAF6F0]/90">
                        &ldquo;Traveling with kids on safari can be daunting, but Gentriiq curated the most thoughtful
                        family-friendly itinerary in Amboseli and Naivasha. Our children will never forget it.&rdquo;
                    </blockquote>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-[#D96B27]/20 font-bold text-[#D96B27]">
                            DL
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#211915] dark:text-white">David & Elena Larsson</p>
                            <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">Sweden &bull; Traveled December
                                2025</p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-sm border border-black/10 bg-white p-8 shadow-xs dark:border-white/10 dark:bg-[#24140E]">
                    <div class="flex text-[#D96B27]">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="size-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="mt-4 text-sm leading-relaxed text-[#211915]/90 dark:text-[#FAF6F0]/90">
                        &ldquo;From airport pickup in Nairobi to the private bush breakfasts in the Mara, Gentriiq made
                        our honeymoon feel magical. Their custom 4x4 cruiser was pristine and comfortable.&rdquo;
                    </blockquote>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-[#D96B27]/20 font-bold text-[#D96B27]">
                            AC
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#211915] dark:text-white">Alex & Chloe Dupont</p>
                            <p class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/60">France &bull; Traveled February
                                2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HIGH-CONVERSION CTA SECTION -->
    <section id="contact" class="relative overflow-hidden bg-[#24140E] py-20 sm:py-28 text-white">
        <div class="absolute -right-24 -bottom-24 size-96 rounded-full bg-[#D96B27]/15 blur-3xl"></div>
        <div class="absolute -left-24 -top-24 size-96 rounded-full bg-[#D96B27]/10 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Start Planning Today</span>
            <h2 class="mx-auto mt-2 max-w-3xl text-3xl font-extrabold sm:text-5xl">
                Ready to Experience Your Dream African Safari?
            </h2>
            <p class="mx-auto mt-6 max-w-2xl text-base text-[#FAF6F0]/80 sm:text-lg">
                Speak directly with our safari planning experts in Nairobi. We will craft a bespoke itinerary tailored
                to your travel dates, budget, and wildlife wishlist.
            </p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <x-button href="{{ route('plan.create') }}" variant="primary" size="lg" class="min-w-52">
                    <span>Plan My Safari</span>
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </x-button>

                <x-button
                    href="https://wa.me/254717838061?text=Hello%20Gentriiq%20Safaris,%20I%20would%20like%20to%20plan%20a%20safari%20trip."
                    target="_blank" rel="noopener noreferrer" variant="outline-white" size="lg"
                    class="min-w-52">
                    <svg class="size-5 fill-current text-[#25D366]" viewBox="0 0 24 24">
                        <path
                            d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.969.54 1.761.815 2.791.815 3.179 0 5.768-2.587 5.769-5.767.001-3.18-2.586-5.767-5.768-5.767zm9.969 5.765c0 5.518-4.482 10-10 10-1.748 0-3.385-.45-4.819-1.242l-5.181 1.357 1.383-5.053c-.886-1.488-1.383-3.228-1.383-5.062 0-5.518 4.482-10 10-10 5.518 0 10 4.482 10 10z" />
                    </svg>
                    Chat on WhatsApp
                </x-button>

                <x-button href="tel:+254717838061" variant="outline-white" size="lg" class="min-w-52">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Call Safari Desk
                </x-button>
            </div>

            <!-- Operating Contacts Info -->
            <div class="mt-12 flex flex-wrap items-center justify-center gap-6 text-sm text-[#FAF6F0]/70">
                <span>Nairobi, Kenya</span>
                <span>&bull;</span>
                <a href="tel:+254717838061" class="font-medium hover:text-white">+254 717 838061 <span
                        class="text-xs text-[#D96B27]"></span></a>
                <span>&bull;</span>
                <a href="tel:+254720115305" class="hover:text-white">+254 720 115305 <span
                        class="text-xs text-white/50">(Office)</span></a>
            </div>
        </div>
    </section>

</x-layouts.public>
