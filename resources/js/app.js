import Alpine from 'alpinejs';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('tiptap', (initialContent = '') => {
        // Tiptap transactions must never use an Alpine reactive proxy.
        let editor;

        return {
            revision: 0,
            content: initialContent,
            init() {
                editor = new Editor({
                    element: this.$refs.editor,
                    extensions: [StarterKit.configure({ heading: { levels: [2, 3] } })],
                    content: this.content,
                    editorProps: {
                        attributes: {
                            class: 'min-h-[200px] p-4 outline-none text-sm leading-relaxed text-[#211915] dark:text-white'
                        }
                    },
                    onTransaction: () => {
                        this.revision++;
                    },
                    onUpdate: ({ editor }) => {
                        this.content = editor.getHTML();
                        this.$refs.input.value = this.content;
                    }
                });
                this.$refs.input.value = editor.getHTML();
                this.revision++;
            },
            destroy() {
                editor?.destroy();
            },
            toggleBold() { editor.chain().focus().toggleBold().run(); },
            toggleItalic() { editor.chain().focus().toggleItalic().run(); },
            toggleH2() { editor.chain().focus().toggleHeading({ level: 2 }).run(); },
            toggleH3() { editor.chain().focus().toggleHeading({ level: 3 }).run(); },
            toggleBulletList() { editor.chain().focus().toggleBulletList().run(); },
            toggleOrderedList() { editor.chain().focus().toggleOrderedList().run(); },
            isActive(type, opts = {}) {
                // Track selection and document changes without making the editor reactive.
                this.revision;
                return editor?.isActive(type, opts) ?? false;
            }
        };
    });

    Alpine.data('tourFormPage', (initial = {}) => ({
        fallbackCountry: initial.fallbackCountry ?? 'Kenya',
        durationDays: initial.durationDays ?? 1,
        status: initial.status ?? 'draft',
        days: initial.days ?? [],
        selectedDestinations: initial.selectedDestinations ?? [],
        destinationOptions: initial.destinationOptions ?? [],
        errors: initial.errors ?? {},

        get selectedDestinationDetails() {
            return this.destinationOptions.filter(item => this.selectedDestinations.includes(String(item.id)));
        },
        get countrySummary() {
            return [...new Set(this.selectedDestinationDetails.map(item => item.country).filter(Boolean))].sort().join(', ');
        },
        addDay() {
            if (this.days.length >= Number(this.durationDays)) return;
            this.days.push({ title: '', location: '', description: '', accommodation: '', meals: '' });
        }
    }));
});

Alpine.start();
