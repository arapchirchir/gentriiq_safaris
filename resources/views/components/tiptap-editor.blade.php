@props(['name', 'content' => ''])

<div x-data="tiptap(@js($content))">
    <input type="hidden" name="{{ $name }}" value="{{ $content }}" x-ref="input">

    {{-- Toolbar --}}
    <div class="flex flex-wrap gap-1 rounded-t-sm border border-black/20 bg-[#FAF6F0] p-2 dark:border-white/20 dark:bg-[#1a0e08]">
        <button type="button" @mousedown.prevent @click="toggleBold()"
            aria-label="Bold" :aria-pressed="isActive('bold')"
            :class="isActive('bold') ? 'bg-[#D96B27] text-white' : 'text-[#211915] hover:bg-black/10 dark:text-white dark:hover:bg-white/10'"
            class="rounded-xs px-2.5 py-1 text-xs font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
            B
        </button>
        <button type="button" @mousedown.prevent @click="toggleItalic()"
            aria-label="Italic" :aria-pressed="isActive('italic')"
            :class="isActive('italic') ? 'bg-[#D96B27] text-white' : 'text-[#211915] hover:bg-black/10 dark:text-white dark:hover:bg-white/10'"
            class="rounded-xs px-2.5 py-1 text-xs italic font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
            I
        </button>
        <div class="mx-1 w-px bg-black/10 dark:bg-white/10"></div>
        <button type="button" @mousedown.prevent @click="toggleH2()"
            aria-label="Heading 2" :aria-pressed="isActive('heading', {level: 2})"
            :class="isActive('heading', {level: 2}) ? 'bg-[#D96B27] text-white' : 'text-[#211915] hover:bg-black/10 dark:text-white dark:hover:bg-white/10'"
            class="rounded-xs px-2.5 py-1 text-xs font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
            H2
        </button>
        <button type="button" @mousedown.prevent @click="toggleH3()"
            aria-label="Heading 3" :aria-pressed="isActive('heading', {level: 3})"
            :class="isActive('heading', {level: 3}) ? 'bg-[#D96B27] text-white' : 'text-[#211915] hover:bg-black/10 dark:text-white dark:hover:bg-white/10'"
            class="rounded-xs px-2.5 py-1 text-xs font-bold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
            H3
        </button>
        <div class="mx-1 w-px bg-black/10 dark:bg-white/10"></div>
        <button type="button" @mousedown.prevent @click="toggleBulletList()"
            aria-label="Bulleted list" :aria-pressed="isActive('bulletList')"
            :class="isActive('bulletList') ? 'bg-[#D96B27] text-white' : 'text-[#211915] hover:bg-black/10 dark:text-white dark:hover:bg-white/10'"
            class="rounded-xs px-2.5 py-1 text-xs font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
            &bull; List
        </button>
        <button type="button" @mousedown.prevent @click="toggleOrderedList()"
            aria-label="Numbered list" :aria-pressed="isActive('orderedList')"
            :class="isActive('orderedList') ? 'bg-[#D96B27] text-white' : 'text-[#211915] hover:bg-black/10 dark:text-white dark:hover:bg-white/10'"
            class="rounded-xs px-2.5 py-1 text-xs font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#D96B27]">
            1. List
        </button>
    </div>

    {{-- Editor area --}}
    <div x-ref="editor"
        class="rounded-b-sm border border-t-0 border-black/20 bg-white dark:border-white/20 dark:bg-[#180D08]
               [&_.ProseMirror]:min-h-[200px] [&_.ProseMirror]:p-4 [&_.ProseMirror]:outline-none
               [&_.ProseMirror_h2]:text-xl [&_.ProseMirror_h2]:font-bold [&_.ProseMirror_h2]:mt-4 [&_.ProseMirror_h2]:mb-2
               [&_.ProseMirror_h3]:text-lg [&_.ProseMirror_h3]:font-semibold [&_.ProseMirror_h3]:mt-3 [&_.ProseMirror_h3]:mb-1
               [&_.ProseMirror_ul]:list-disc [&_.ProseMirror_ul]:pl-5 [&_.ProseMirror_ul]:my-2
               [&_.ProseMirror_ol]:list-decimal [&_.ProseMirror_ol]:pl-5 [&_.ProseMirror_ol]:my-2
               [&_.ProseMirror_p]:my-1.5
               [&_.ProseMirror_strong]:font-bold [&_.ProseMirror_em]:italic">
    </div>
</div>
