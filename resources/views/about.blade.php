@php
    // TODO: Add real team members. The section stays hidden while this list is empty.
    // Photos must live in public/assets/team/ (the CSP only allows local and Unsplash images).
    // Example: ['name' => 'Jane Wanjiru', 'role' => 'Founder & Safari Director', 'photo' => 'assets/team/jane.jpg', 'bio' => '...'],
    $team = [];

    // TODO: Add only licences and memberships the company actually holds. The section stays hidden while empty.
    // Example: ['name' => 'Kenya Association of Tour Operators (KATO)', 'detail' => 'Member No. 1234'],
    $credentials = [];

    $whatsAppUrl =
        'https://wa.me/254717838061?text=' .
        rawurlencode('Hello Gentriiq Safaris & Tours, I would like to plan a safari.');
@endphp

<x-layouts.public title="About Us"
    description="Meet Gentriiq Safaris & Tours — a Narok-based ground operator crafting tailor-made wildlife safaris across Kenya, Tanzania, Uganda, and Rwanda with local naturalist guides.">

    <!-- HERO -->
    <section class="relative flex min-h-[60vh] items-center overflow-hidden bg-[#180D08] text-white">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=2000&q=80"
                alt="Safari vehicle on the East African savannah" class="size-full object-cover object-center opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-[#180D08] via-[#180D08]/60 to-black/40"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-6 text-sm text-[#FAF6F0]/70">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <span aria-current="page" class="text-white">About Us</span>
            </nav>
            <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">About Gentriiq Safaris &
                Tours</span>
            <h1 class="mt-3 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-6xl">
                Local Experts. <span class="text-[#D96B27]">Personal Journeys.</span>
            </h1>
            <p class="mt-6 max-w-2xl text-base text-[#FAF6F0]/85 sm:text-xl sm:leading-relaxed">
                We are a safari operator based in Narok, the gateway to the Maasai Mara, crafting tailor-made wildlife adventures across Kenya,
                Tanzania, Uganda, and Rwanda — planned by people who live here and guided by naturalists who know
                the land.
            </p>
            <div class="mt-10 flex flex-wrap items-center gap-4">
                <x-button href="{{ route('plan.create') }}" variant="primary" size="lg" class="min-w-44">
                    <span>Plan My Safari</span>
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </x-button>
                <x-button href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" variant="outline-white"
                    size="lg" class="min-w-44">
                    Chat on WhatsApp
                </x-button>
            </div>
        </div>
    </section>

    <!-- OUR STORY -->
    <section id="story" class="bg-[#FAF6F0] py-20 sm:py-28 dark:bg-[#180D08]">
        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Our Story</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    Born in East Africa, Built Around You
                </h2>
                {{-- TODO: Replace with the real founding story (who founded Gentriiq, when, and why). --}}
                <div class="mt-6 space-y-4 text-base leading-7 text-[#6E635C] dark:text-[#FAF6F0]/70">
                    <p>
                        Gentriiq Safaris & Tours was built on a simple belief: the best way to experience East Africa
                        is with the people who call it home. From our base in Narok, on the doorstep of the Maasai Mara, we design every journey
                        ourselves — no call centres, no middlemen, just direct conversations with the team that will
                        look after you on the ground.
                    </p>
                    <p>
                        Our naturalist guides bring more than 15 years of field expertise, tracking wildlife
                        movements daily across the region's great reserves. That knowledge shapes every itinerary we
                        write, from a first-time Big Five safari to a Great Migration expedition or a bush-to-beach
                        honeymoon.
                    </p>
                </div>
            </div>
            <div class="relative aspect-4/3 overflow-hidden rounded-sm bg-black/10">
                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1200&q=80"
                    alt="Cheetah scanning the savannah in the Maasai Mara" loading="lazy"
                    class="size-full object-cover">
            </div>
        </div>

        <!-- Key Facts Strip -->
        <div class="mx-auto mt-16 max-w-7xl px-4 sm:px-6 lg:px-8">
            <dl class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="rounded-sm border border-black/10 bg-white p-5 dark:border-white/10 dark:bg-[#24140E]">
                    <dt class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Field Expertise</dt>
                    <dd class="mt-1 text-2xl font-bold text-[#D96B27]">15+ Yrs</dd>
                </div>
                <div class="rounded-sm border border-black/10 bg-white p-5 dark:border-white/10 dark:bg-[#24140E]">
                    <dt class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Countries Covered</dt>
                    <dd class="mt-1 text-2xl font-bold text-[#D96B27]">4</dd>
                </div>
                <div class="rounded-sm border border-black/10 bg-white p-5 dark:border-white/10 dark:bg-[#24140E]">
                    <dt class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Tailor-Made Itineraries</dt>
                    <dd class="mt-1 text-2xl font-bold text-[#D96B27]">100%</dd>
                </div>
                <div class="rounded-sm border border-black/10 bg-white p-5 dark:border-white/10 dark:bg-[#24140E]">
                    <dt class="text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">Trip & Field Support</dt>
                    <dd class="mt-1 text-2xl font-bold text-[#D96B27]">24/7</dd>
                </div>
            </dl>
        </div>
    </section>

    <!-- MID-PAGE CTA -->
    <section class="bg-[#D96B27] py-10 text-white">
        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 text-center sm:px-6 md:flex-row md:text-left lg:px-8">
            <div>
                <p class="text-xl font-bold sm:text-2xl">Have a safari in mind?</p>
                <p class="mt-1 text-sm text-white/85">Tell us your dates and wishlist — we'll design the itinerary
                    around you.</p>
            </div>
            <x-button href="{{ route('plan.create') }}" variant="outline-white" size="lg" class="shrink-0">
                Start Planning
            </x-button>
        </div>
    </section>

    <!-- MISSION & VALUES -->
    <section id="values" class="bg-white py-20 sm:py-28 dark:bg-[#1A0D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">What Guides Us</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    Our Mission & Values
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm text-[#6E635C] sm:text-base dark:text-[#FAF6F0]/70">
                    To share the wild heart of East Africa through deeply personal journeys — delivered with honesty,
                    care, and respect for the land and its people.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-3">
                <div class="border-l-4 border-[#D96B27] pl-6">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Personal, Never Packaged</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Every itinerary is shaped around your dates, budget, travel style, and wildlife wishlist.
                    </p>
                </div>
                <div class="border-l-4 border-[#D96B27] pl-6">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Honest & Accountable</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        You deal directly with the operator who runs your trip — clear pricing and one team
                        responsible from first message to final drive.
                    </p>
                </div>
                <div class="border-l-4 border-[#D96B27] pl-6">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Respect for the Wild</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        We travel responsibly, so the wildlife and communities you meet thrive long after you leave.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT MAKES US DIFFERENT -->
    <section id="difference" class="bg-[#FAF6F0] py-20 sm:py-28 dark:bg-[#180D08]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">The Gentriiq Advantage</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    What Makes Us Different
                </h2>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2">
                <div class="rounded-sm border border-black/10 bg-white p-6 dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Local East African Experts</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Born and raised in East Africa, our safari naturalists track wildlife movements daily and know
                        every hidden corner of the national reserves.
                    </p>
                </div>
                <div class="rounded-sm border border-black/10 bg-white p-6 dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Direct Operator Pricing</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        No middleman fees. You book directly with the local ground operator in Narok, ensuring the
                        best value and absolute accountability.
                    </p>
                </div>
                <div class="rounded-sm border border-black/10 bg-white p-6 dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Custom 4x4 Land Cruisers</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        Pop-up game viewing roofs, charging outlets, binoculars, high-frequency radios, and a
                        guaranteed window seat for every traveler.
                    </p>
                </div>
                <div class="rounded-sm border border-black/10 bg-white p-6 dark:border-white/10 dark:bg-[#24140E]">
                    <h3 class="text-lg font-bold text-[#211915] dark:text-white">Support Around the Clock</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/70">
                        From airport pickup to your final game drive, our Narok team is a phone call or WhatsApp
                        message away, 24/7.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CONSERVATION & COMMUNITY -->
    <section id="conservation" class="bg-white py-20 sm:py-28 dark:bg-[#1A0D08]">
        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div class="relative order-last aspect-4/3 overflow-hidden rounded-sm bg-black/10 lg:order-first">
                <img src="https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?auto=format&fit=crop&w=1200&q=80"
                    alt="Elephants in Amboseli National Park" loading="lazy" class="size-full object-cover">
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Responsible Travel</span>
                <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">
                    Conservation & Community
                </h2>
                {{-- TODO: Name the specific conservancies/trusts supported and any measurable contributions. --}}
                <div class="mt-6 space-y-4 text-base leading-7 text-[#6E635C] dark:text-[#FAF6F0]/70">
                    <p>
                        The wildlife that brings travelers to East Africa depends on protected land and the
                        communities who share it. We actively support wildlife conservation trusts and partner
                        directly with indigenous Maasai and Samburu community conservancies.
                    </p>
                    <p>
                        Wherever possible we choose locally owned camps and lodges, employ local guides, and
                        encourage low-impact game viewing, so your safari gives back to the places that make it
                        unforgettable.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($team))
        <!-- TEAM -->
        <section id="team" class="bg-[#FAF6F0] py-20 sm:py-28 dark:bg-[#180D08]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">The People Behind Your
                        Safari</span>
                    <h2 class="mt-2 text-3xl font-extrabold text-[#211915] sm:text-4xl dark:text-white">Meet Our Team
                    </h2>
                </div>
                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($team as $member)
                        <div
                            class="overflow-hidden rounded-sm border border-black/10 bg-white dark:border-white/10 dark:bg-[#24140E]">
                            <div class="aspect-square bg-black/10">
                                <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}" loading="lazy"
                                    class="size-full object-cover">
                            </div>
                            <div class="p-5">
                                <h3 class="text-base font-bold text-[#211915] dark:text-white">{{ $member['name'] }}
                                </h3>
                                <p class="text-xs font-semibold text-[#D96B27]">{{ $member['role'] }}</p>
                                @if (!empty($member['bio']))
                                    <p class="mt-3 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">{{ $member['bio'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!empty($credentials))
        <!-- LICENCES & MEMBERSHIPS -->
        <section id="credentials" class="bg-white py-16 dark:bg-[#1A0D08]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-center text-xs font-bold uppercase tracking-wider text-[#D96B27]">Licensed & Trusted
                </h2>
                <ul class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($credentials as $credential)
                        <li
                            class="rounded-sm border border-black/10 bg-[#FAF6F0] p-5 text-center dark:border-white/10 dark:bg-[#24140E]">
                            <p class="text-sm font-bold text-[#211915] dark:text-white">{{ $credential['name'] }}</p>
                            @if (!empty($credential['detail']))
                                <p class="mt-1 text-xs text-[#6E635C] dark:text-[#FAF6F0]/70">
                                    {{ $credential['detail'] }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    <!-- EXPLORE CTA: real tours & destinations -->
    <section class="bg-[#FAF6F0] py-16 dark:bg-[#180D08]">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 sm:px-6 md:grid-cols-2 lg:px-8">
            <a href="{{ route('home') }}#safaris"
                class="group rounded-sm border border-black/10 bg-white p-8 transition-shadow hover:shadow-lg focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:border-white/10 dark:bg-[#24140E]">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Handcrafted Journeys</span>
                <p class="mt-2 text-2xl font-extrabold text-[#211915] group-hover:text-[#D96B27] dark:text-white">
                    Browse Safari Packages &rarr;</p>
                <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">Proven itineraries you can book as-is or
                    tailor to your trip.</p>
            </a>
            <a href="{{ route('home') }}#destinations"
                class="group rounded-sm border border-black/10 bg-white p-8 transition-shadow hover:shadow-lg focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:border-white/10 dark:bg-[#24140E]">
                <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Explore the Wilderness</span>
                <p class="mt-2 text-2xl font-extrabold text-[#211915] group-hover:text-[#D96B27] dark:text-white">
                    Discover Destinations &rarr;</p>
                <p class="mt-2 text-sm text-[#6E635C] dark:text-[#FAF6F0]/70">From the Maasai Mara to the Serengeti and
                    the Indian Ocean coast.</p>
            </a>
        </div>
    </section>

    <!-- FINAL CTA -->
    <section id="contact" class="relative overflow-hidden bg-[#24140E] py-20 text-white sm:py-28">
        <div class="absolute -right-24 -bottom-24 size-96 rounded-full bg-[#D96B27]/15 blur-3xl"></div>
        <div class="relative z-10 mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <span class="text-xs font-bold uppercase tracking-wider text-[#D96B27]">Start Planning Today</span>
            <h2 class="mx-auto mt-2 max-w-3xl text-3xl font-extrabold sm:text-5xl">
                Let's Plan Your East African Adventure
            </h2>
            <p class="mx-auto mt-6 max-w-2xl text-base text-[#FAF6F0]/80 sm:text-lg">
                Speak directly with our safari planning team in Narok. We'll craft a bespoke itinerary tailored to
                your travel dates, budget, and wildlife wishlist.
            </p>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <x-button href="{{ route('plan.create') }}" variant="primary" size="lg" class="min-w-52">
                    Plan My Safari
                </x-button>
                <x-button href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer"
                    variant="outline-white" size="lg" class="min-w-52">
                    Chat on WhatsApp
                </x-button>
                <x-button href="tel:+254717838061" variant="outline-white" size="lg" class="min-w-52">
                    Call Safari Desk
                </x-button>
            </div>
            {{-- TODO: Add the office street address (and email, if it should be public). --}}
            <div class="mt-12 flex flex-wrap items-center justify-center gap-6 text-sm text-[#FAF6F0]/70">
                <span>Narok, Kenya</span>
                <span>&bull;</span>
                <a href="tel:+254717838061" class="font-medium hover:text-white">+254 717 838061</a>
                <span>&bull;</span>
                <a href="tel:+254720115305" class="hover:text-white">+254 720 115305 <span
                        class="text-xs text-white/50"></span></a>
            </div>
        </div>
    </section>

</x-layouts.public>
