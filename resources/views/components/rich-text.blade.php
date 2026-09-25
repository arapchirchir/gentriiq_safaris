@props(['content' => ''])

<div {{ $attributes->class([
    'break-words [&_p]:my-2 [&_h2]:mt-6 [&_h2]:mb-3 [&_h2]:text-2xl [&_h2]:font-bold
    [&_h3]:mt-4 [&_h3]:mb-2 [&_h3]:text-xl [&_h3]:font-semibold
    [&_strong]:font-bold [&_b]:font-bold [&_em]:italic [&_i]:italic
    [&_ul]:my-3 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:my-3 [&_ol]:list-decimal [&_ol]:pl-6
    [&_li]:my-1 [&_blockquote]:border-l-4 [&_blockquote]:border-[#D96B27] [&_blockquote]:pl-4
    [&_pre]:overflow-x-auto [&_pre]:whitespace-pre-wrap [&_s]:line-through [&_u]:underline',
]) }}>
    {!! app(\App\Actions\RenderRichText::class)($content) !!}
</div>
