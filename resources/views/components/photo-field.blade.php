@props(['name', 'value' => null, 'label' => 'Photo'])

@php
    // Uploaded photos default to the upload tab; external links to the link tab.
    $mode = filled($value) && ! \App\Actions\SavePhoto::isUploaded($value) ? 'link' : 'upload';
    $link = $mode === 'link' ? $value : '';
    $maxBytes = 15 * 1024 * 1024;
@endphp

<div {{ $attributes->class('space-y-3') }}
    x-data="{
        mode: @js($mode),
        value: @js($value),
        link: @js($link),
        preview: @js($value),
        fileName: '',
        fileSize: '',
        dragging: false,
        error: '',
        accept(file) {
            if (!file) return;
            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                this.error = 'Please choose a JPG, PNG or WebP photo.';
                return this.resetInput();
            }
            if (file.size > {{ $maxBytes }}) {
                this.error = 'This photo is larger than 15 MB. Please choose a smaller one.';
                return this.resetInput();
            }
            this.error = '';
            this.fileName = file.name;
            this.fileSize = file.size >= 1048576 ? (file.size / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(file.size / 1024)) + ' KB';
            this.preview = URL.createObjectURL(file);
        },
        pick(event) {
            this.accept(event.target.files[0]);
        },
        drop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (!file) return;
            // Hand the dropped file to the real input so it is submitted with the form.
            const transfer = new DataTransfer();
            transfer.items.add(file);
            this.$refs.file.files = transfer.files;
            this.accept(file);
        },
        browse() {
            this.$refs.file.click();
        },
        useLink() {
            this.value = this.link;
            this.preview = this.link;
            this.error = '';
            this.resetInput();
        },
        resetInput() {
            this.fileName = '';
            this.fileSize = '';
            this.$refs.file.value = '';
        },
        clear() {
            this.value = '';
            this.link = '';
            this.preview = '';
            this.error = '';
            this.resetInput();
        }
    }">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <span class="text-xs font-bold uppercase tracking-wider text-[#6E635C] dark:text-[#FAF6F0]/70">{{ $label }}</span>
        <div class="inline-flex rounded-sm border border-black/15 bg-[#FAF6F0] p-0.5 text-xs font-semibold dark:border-white/15 dark:bg-[#180D08]"
            role="group" aria-label="Photo source">
            @foreach (['upload' => 'Upload photo', 'link' => 'Paste link'] as $option => $text)
                <button type="button" @click="mode = @js($option)" :data-selected="mode === @js($option)"
                    @if ($mode === $option) data-selected="true" @endif
                    :aria-pressed="mode === @js($option)"
                    class="rounded-xs px-3 py-1.5 text-[#6E635C] transition-colors hover:text-[#211915] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:text-[#FAF6F0]/70 dark:hover:text-white data-selected:bg-[#D96B27] data-selected:text-white data-selected:shadow-xs data-selected:hover:text-white">
                    {{ $text }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Always submitted: the external link or the existing uploaded path. A new file upload takes precedence server-side. --}}
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" :value="value">
    <input type="file" id="{{ $name }}_upload" name="{{ $name }}_upload" x-ref="file" @change="pick($event)"
        accept="image/jpeg,image/png,image/webp" class="sr-only" tabindex="-1" aria-hidden="true">

    {{-- Preview card: shown whenever there is a photo (saved, linked or newly chosen). --}}
    <div x-show="preview" @if (blank($value)) x-cloak @endif
        class="overflow-hidden rounded-sm border border-black/10 bg-[#FAF6F0] dark:border-white/10 dark:bg-[#180D08]">
        <img @if (filled($value)) src="{{ $value }}" @endif :src="preview" alt="{{ $label }} preview"
            class="h-56 w-full bg-black/5 object-cover dark:bg-white/5">
        <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3">
            <div class="min-w-0">
                <p class="truncate text-xs font-semibold text-[#211915] dark:text-white"
                    x-text="fileName || (mode === 'link' ? 'Linked photo' : 'Current photo')">
                    {{ $mode === 'link' ? 'Linked photo' : 'Current photo' }}</p>
                <p class="text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60"
                    x-text="fileName ? fileSize + ' · ready to upload when you save' : 'Saved with this record'">
                    Saved with this record</p>
            </div>
            <div class="flex shrink-0 items-center gap-2">
                <button type="button" x-show="mode === 'upload'" @if ($mode !== 'upload') x-cloak @endif @click="browse()"
                    class="rounded-sm border border-black/15 bg-white px-3 py-1.5 text-[11px] font-semibold text-[#211915] hover:border-[#D96B27] hover:text-[#D96B27] focus-visible:outline-2 focus-visible:outline-[#D96B27] dark:border-white/15 dark:bg-[#24140E] dark:text-white">
                    Replace
                </button>
                <button type="button" @click="clear()"
                    class="rounded-sm border border-red-500/30 px-3 py-1.5 text-[11px] font-semibold text-red-600 hover:bg-red-500/10 focus-visible:outline-2 focus-visible:outline-red-500">
                    Remove
                </button>
            </div>
        </div>
    </div>

    {{-- Drop zone: upload mode without a photo yet. --}}
    <div x-show="mode === 'upload' && !preview" @if ($mode !== 'upload' || filled($value)) x-cloak @endif>
        <button type="button" @click="browse()"
            @dragover.prevent="dragging = true" @dragenter.prevent="dragging = true"
            @dragleave.prevent="dragging = false" @drop.prevent="drop($event)"
            :data-dragging="dragging"
            class="group flex min-h-48 w-full flex-col items-center justify-center gap-3 rounded-sm border-2 border-dashed border-black/20 bg-[#FAF6F0] px-6 py-10 text-center transition-colors hover:border-[#D96B27] hover:bg-[#D96B27]/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:hover:border-[#D96B27] data-dragging:border-[#D96B27] data-dragging:bg-[#D96B27]/10">
            <span class="flex size-12 items-center justify-center rounded-full bg-white text-[#D96B27] shadow-xs ring-1 ring-black/5 dark:bg-[#24140E] dark:ring-white/10">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
            </span>
            <span class="text-sm text-[#211915] dark:text-white">
                <span class="font-bold" x-text="dragging ? 'Drop to add this photo' : 'Drag a photo here'">Drag a photo here</span>
                <span x-show="!dragging">or <span class="font-bold text-[#D96B27] underline decoration-[#D96B27]/40 underline-offset-2 group-hover:decoration-[#D96B27]">browse your device</span></span>
            </span>
            <span class="text-[11px] leading-relaxed text-[#6E635C] dark:text-[#FAF6F0]/60">
                JPG, PNG or WebP &middot; up to 15 MB<br>
                Resized for the web and location data removed automatically
            </span>
        </button>
    </div>

    {{-- Link mode input --}}
    <div x-show="mode === 'link'" @if ($mode !== 'link') x-cloak @endif>
        <label for="{{ $name }}_link" class="sr-only">{{ $label }} link</label>
        <input type="url" id="{{ $name }}_link" x-model="link" @input="useLink()" maxlength="255" value="{{ $link }}"
            placeholder="https://images.unsplash.com/..."
            class="w-full rounded-sm border border-black/20 bg-white px-3.5 py-2.5 text-sm text-[#211915] focus:outline-2 focus:outline-[#D96B27] dark:border-white/20 dark:bg-[#180D08] dark:text-white">
        <p class="mt-1 text-[11px] text-[#6E635C] dark:text-[#FAF6F0]/60">Links must be to Unsplash or this website to display publicly.</p>
    </div>

    <p x-show="error" x-cloak x-text="error" class="text-xs text-red-600 dark:text-red-400" role="alert"></p>
    <x-form-error name="{{ $name }}_upload" />
    <x-form-error name="{{ $name }}" />
</div>
