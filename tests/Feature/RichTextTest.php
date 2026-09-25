<?php

use App\Actions\RenderRichText;

test('rich text displays editor formatting', function () {
    $content = '<h2>Safari overview</h2><h3>Highlights</h3><p><strong>Bold</strong> and <em>italic</em></p><ul><li>Lions</li></ul><ol><li>Arrival</li></ol>';

    $this->blade('<x-rich-text :content="$content" />', ['content' => $content])
        ->assertSee($content, false);
});

test('rich text removes executable markup and attributes', function () {
    $content = '<h2 onclick="alert(1)">Heading</h2><script>alert(1)</script><p style="color:red" x-data="alert(1)"><strong onmouseover="alert(1)">Safe</strong><img src=x onerror="alert(1)"><a href="javascript:alert(1)">Link text</a></p>';

    $html = app(RenderRichText::class)($content);

    expect($html)->toBe('<h2>Heading</h2><p><strong>Safe</strong>Link text</p>');
});

test('rich text preserves plain text unicode and escaped entities', function () {
    $html = app(RenderRichText::class)('Kenya &amp; Tanzania — café &lt;script&gt;');

    expect($html)->toContain('Kenya &amp; Tanzania — café &lt;script&gt;')
        ->not->toContain('<script>');
});

test('empty rich text is supported', function () {
    expect(app(RenderRichText::class)(null))->toBe('')
        ->and(app(RenderRichText::class)(''))->toBe('');
});
