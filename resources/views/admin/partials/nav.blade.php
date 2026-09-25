{{-- Staff navigation shared by the desktop sidebar and the mobile drawer. Expects $navigation. --}}
<nav class="flex min-h-full flex-col gap-6 px-4 py-6">
    <div>
        <p class="px-2.5 text-[11px] font-bold uppercase tracking-wider text-white/40">Core Operations</p>
        <ul role="list" class="mt-2 space-y-1">
            @foreach ($navigation as $item)
                @php($active = request()->routeIs($item['active']))
                <li>
                    <a href="{{ route($item['route']) }}" @if ($mobile ?? false) @click="mobileSidebarOpen = false" @endif
                        @if ($active) aria-current="page" @endif
                        class="{{ $active ? 'bg-[#D96B27] font-bold text-white shadow-xs' : 'text-[#FAF6F0]/70 hover:bg-white/5 hover:text-white' }} flex items-center justify-between gap-3 rounded-sm px-2.5 py-2.5 text-xs font-semibold focus-visible:outline-2 focus-visible:outline-[#D96B27]">
                        <span class="flex items-center gap-3">
                            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                @foreach ($item['icon'] as $path)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}" />
                                @endforeach
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </span>
                        @if (! empty($item['badge']))
                            <span class="rounded-full bg-emerald-500 px-2 py-0.5 text-[10px] font-black text-white">
                                {{ $item['badge'] }}<span class="sr-only"> new</span>
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
